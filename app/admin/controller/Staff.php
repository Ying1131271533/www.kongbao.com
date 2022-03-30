<?php
namespace app\admin\controller;

use think\facade\Request;
use think\facade\Db;
use think\Facade;
use think\facade\View;
use app\common\model\Staff as Staffs;

class Staff extends Base
{
	//员工管理页面
	public function index(){
		$link = Db::table('Admin')->order('create_time', 'desc')->select();
		$res = count($link);
		$this -> assign('count',$res);
		$this -> assign('link_result',$link);
		return $this -> fetch();
	} 


	
}
