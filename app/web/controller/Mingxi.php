<?php
namespace app\web\controller;

use app\common\model\Mingxi as M;

class Mingxi extends Base
{		
		//资金明细列表
    public function index()
	{
		$list = M::where('user_id', session('userid')) -> order('id DESC') -> paginate(20);
		$page = $list -> render();
		
		$this -> assign('list', $list);
		$this -> assign('page', $page);
		return $this -> fetch();
	}
	
}


















