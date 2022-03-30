<?php
namespace app\web\controller;

use app\common\model\User;
use app\common\controller\ViewController;

class Register extends ViewController
{
    //注册
    public function index()
    {
		if(request() ->isPost())
		{
          
            $data = [
				'username' => input('buy_name/s'),
                'email'    => input('buy_emall/s'),
				'password' => input('buy_pass/s'),	
				'uid'      => input('uid'),
			];
			
            $code = input('code');
			if(!captcha_check($code)){
				return json(['code' => 2, 'msg' => '验证码错误']);
            }
			
            //验证规则
			$result = $this -> validate($data, 'User.register');
			if($result !== true)
			{
				return json(['code' => 2, 'msg' => $result]);
			}
		
			
			$user               		= new User;
			$user -> username           = $data['username'];//用户名
			$user -> password       	= $data['password'];//密码
			$user -> email          	= $data['email'];//邮箱
			$user -> create_time    	= time();//注册时间
			$user -> create_ip      	= $_SERVER['REMOTE_ADDR'];//获取客户端ip 
			$user -> last_login_ip		= $_SERVER['REMOTE_ADDR']; // 登录的ip
			$user -> last_login_time	= time(); // 登录的时间
			$user -> isvalid        	= 1;//是否有效 1-有效 2-待审 0-无效
			$user -> login_counts       = 1;// 登录次数
			if($data['uid']){
				$user -> recommend_id       = $data['uid'];//邀请人id
			}else{
				$user -> recommend_id       = 0;//邀请人id
			}
			$result = $user->save();
			
			if (empty($result)) {
				return json(['code' => 2, 'msg' => '注册失败']);
			}
			
			session('userid', $user -> id);
			session('username', $user -> username);
			return json(['code' => 3, 'msg' => '注册成功']);
			
            
        }
		
		return $this -> fetch();
    }
	

}
