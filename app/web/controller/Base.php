<?php
namespace app\web\controller;

use app\common\controller\ViewController;
use app\common\model\User;

class Base extends ViewController
{
	public function __construct(\think\App $app)
	{
		parent::__construct($app);
		
		if (! session('?userid'))
		{
			return $this -> redirect("login/index");
		}
		
		
		$id = session('userid');
		$user = User::find($id);
		$this -> assign('user', $user);
	}
	
}
