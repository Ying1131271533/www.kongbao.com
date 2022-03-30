<?php
namespace app\web\controller;

use app\common\model\Vip as V;
use app\common\model\Kd;

class Vip extends Base
{
	// vip升级
	function index()
	{
		if(request() -> isPost())
		{
			dump(input());
			return;
		}
		
		$where = [
			['status', '=', 1],
			['ms', 'in', '1,2,3'],
			['type', '=', 1],
		];
		
		$list = Kd::where($where) -> order('sort_order asc') -> select();
		$vip = V::find();
		
		$this -> assign('list', $list);
		$this -> assign('vip', $vip);
		return $this -> fetch();
	}
	
    
	
}


















