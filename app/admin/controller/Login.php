<?php
namespace app\admin\controller;

use app\common\controller\ViewController;
use app\common\model\Admin;

class Login extends ViewController
{
	/* protected $middleware = [ 
    	'app\admin\middleware\AutoLogin::class' 	=> ['except' 	=> ['logout', 'hello'] ], // 排除
        'app\admin\middleware\AutoLogin::class' 	=> ['only' 		=> ['index'] ], // 只有
    ]; */
	
	// 登录
	function index()
	{
		if(request() -> isAjax())
		{
			$data = [
				'name' => input('name/s'),
				'password' => input('password/s'),
			];
			
			$code = input('vercode');
			if(captcha_check($code) !== true)
			{
				return ['code' => 2, 'msg' => '验证码错误'];
			}
			
			$valiResult = $this -> validate($data, 'Login');
			if($valiResult !== true)
			{
				return ['code' => 2, 'msg' => $valiResult];
			}
			
			$admin = Admin::where('name', $data['name']) -> find();
			if(empty($admin))
			{
				return ['code' => 2, 'msg' => '找不到该用户名'];
			}
			
			//判断密码是否正确
			if($admin['password'] !== md5($data['password']))
			{
				return ['code' => 2, 'msg' => '密码错误'];
			}
			
			// 是否被禁止登录
			if($admin['status'] == 2)
			{
				session('admin', null);
				cookie('admin_name', null);
				cookie('admin_pass', null);
				return ['code' => 2, 'msg' => '用户已被禁止登录'];
			}
			
			// 记录登录次数
			$admin -> login_num = (int)$admin['login_num'] + 1;
			$admin -> login_ip = $_SERVER['REMOTE_ADDR'];
			$admin -> last_login_time = time();
			$admin -> save();
			
			// 记录登录状态
			session('admin', ['id' => $admin['id'], 'name' => $admin['name']]);
			
			// 保存权限
			if(config('app.auth.type') == 2 && ! in_array($admin['name'], config('app.auth.super')))
			{
				$Auth = new Auth;
				$access = $Auth -> getAccess($admin['id']);
				session('admin.access', $access);
			}
			
			// 是否自动登录
			if(input('remember') === 'true')
			{
				// 如果存在，则记住用户登录
				cookie('admin_name', encrypt($admin['name'], 'E', config('app.encrypt_key', 3600 * 24 * 15)));
				cookie('admin_pass', encrypt($admin['password'], 'E', config('app.encrypt_key')) , 3600 * 24 * 15);
				
			}else
			{
				cookie('admin_name', null);
				cookie('admin_pass', null);
			}
			
			
			return ['code' => 1, 'msg' => '登录成功'];
		}
		
		return $this -> fetch();
	}
	
	
	
	// 退出登录
	function logout()
	{
		// 删除登录状态
		session('admin', null);
		cookie('admin_name', null);
		cookie('admin_pass', null);
		
		if (cookie('?admin_name'))
		{
			session('admin', null);
			cookie('admin_name', null);
			cookie('admin_pass', null);
		}
		return json(['code' => 0, 'msg' => '退出成功']);
	}
	
	function hello()
	{
		echo '阿卡丽';
	}
}
















