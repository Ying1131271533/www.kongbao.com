<?php
namespace app\admin\controller;

use app\common\controller\ViewController;

class Base extends ViewController
{
	
	public function __construct(\think\App $app)
	{
		parent::__construct($app);
		if(! session('?admin'))
		{
			return $this -> error('请登录', url('login/index'));
		}
		
		$this -> auth();
	}
	
	protected function auth()
	{
		$Auth = new Auth;
		$result = $Auth -> check();
		if($result === false)
		{
			return $this -> error('您没有该页面的访问权限', url('home/info'));
		}
		
		if($result === 2)
		{
			return $this -> error('您已被停用权限', url('home/info'));
		}
	}
}
