<?php
namespace app\admin\middleware;

use app\common\controller\ViewController;
use app\common\model\Admin;

class AutoLogin extends ViewController
{
	public function handle($request, \Closure $next)
    {
        // 添加中间件执行代码
		$this -> index();
        return $next($request);
    }
	
	// 自动登录
	protected function index()
	{
		// 判断用户是否自动登录
		if(cookie('?admin_name') && cookie('?admin_pass'))
		{
			$name = encrypt(cookie('admin_name'), 'D', config('app.encrypt_key'));
			$password = encrypt(cookie('admin_pass'), 'D', config('app.encrypt_key'));
			$admin = Admin::where('name', $name) -> where('password', $password) -> find();
			
			if(empty($admin))
			{
				cookie('admin_name', null);
				cookie('admin_pass', null);
				return $this -> error('请重新登录', url('login/index'));
			}
			
			// 是否被禁止登录
			if($admin['status'] == 2)
			{
				session('admin', null);
				cookie('admin_name', null);
				cookie('admin_pass', null);
				return $this -> error('用户已被禁止登录', url('login/index'));
			}
			
			
			// 记录登录次数
			$admin -> login_num = (int)$admin['login_num'] + 1;
			$admin -> login_ip = $_SERVER['REMOTE_ADDR'];
			$admin -> last_login_time = time();
			$admin -> save();
			
			session('admin', ['id' => $admin['id'], 'name' => $admin['name']]);
			
			// 保存权限
			if(config('app.auth.type') == 2 && ! in_array($admin['name'], config('app.auth.super')))
			{
				$Auth = new Auth;
				$access = $Auth -> getAccess($admin['id']);
				sessoin('admin.access', $access);
			}
			// dump(session('admin'));return;
			
			// 成功跳转地址
			return $this -> success('登录成功', url('home/index'));
		}
	}
	
	
}
















