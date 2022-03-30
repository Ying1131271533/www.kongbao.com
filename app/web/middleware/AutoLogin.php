<?php
namespace app\web\middleware;

use app\common\controller\ViewController;
use app\common\model\User;

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
		if(cookie('?user_name') && cookie('?user_pass'))
		{
			$name = encrypt(cookie('user_name'), 'D', config('app.encrypt_key'));
			$password = encrypt(cookie('user_pass'), 'D', config('app.encrypt_key'));
			$user = User::where('name', $name) -> where('password', $password) -> find();
			if(empty($user))
			{
				cookie('user_name', null);
				cookie('user_pass', null);
				return $this -> error('请重新登录', url('login/index'));
			}
			
			// 是否被禁止登录
			if($user['status'] == 2)
			{
				session('user', null);
				cookie('user_name', null);
				cookie('user_pass', null);
				return $this -> error('用户已被禁止登录', url('login/index'));
			}
			
			
			// 记录登录次数
			$user -> login_num = (int)$user['login_num'] + 1;
			$user -> login_ip = $_SERVER['REMOTE_ADDR'];
			$user -> last_login_time = time();
			$user -> save();
			
			session('user', ['id' => $user['id'], 'name' => $user['name']]);
			// 保存权限
			if(config('app.auth.type') == 2 && ! in_array($user['name'], config('app.auth.super')))
			{
				$Auth = new Auth;
				$access = $Auth -> getAccess($user['id']);
				sessoin('user.access', $access);
			}
			// dump(session('user'));return;
			
			// 成功跳转地址
			return $this -> success('登录成功', url('home/index'));
		}
	}
	
	
}
















