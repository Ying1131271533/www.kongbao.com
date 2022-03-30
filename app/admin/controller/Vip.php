<?php
namespace app\admin\controller;

use think\facade\Request;
use think\facade\Db;
use think\facade\View;
use app\common\model\Vip as vips;

class Vip extends Base
{
	//Vip页面
	public function index(){

		$vip = Db::table('vip')->where('id', 1)->find();
		$this -> assign('vipres',$vip);
		return $this -> fetch();
	}
		//修改会员价格
	public function vip_update()
	{
		$level2 = Request::param('level2');
		$level3 = Request::param('level3');
		$level4 = Request::param('level4');
		$id   	=    Request::param('id');
		$wheres['id'] = $id;
		$vip = vips::where($wheres)->find();
		$vip->id    	= $id;
		$vip->level2    = $level2;
		$vip->level3    = $level3;
		$vip->level4    = $level4;
		$vip->save();
		if($vip){
			$data = $this->success('修改成功');

		}else{
			$data = $this->error('修改失败');
		}
	}


	
}
