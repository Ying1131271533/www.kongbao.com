<?php
namespace app\admin\controller;

use app\common\model\Admin;

class Home extends Base
{
	public function index()
    {
		$admin = session('admin');
		$Auth = new Auth;
		$node = $Auth -> getShowNode($admin);
		$node = get_child($node);
		// dump($node);
		// return;
		$this -> assign('node', $node);
		return $this -> fetch();
    }
	
    public function info()
    {
		$admin = Admin::find(session('admin.id'));
		$this -> assign('admin', $admin);
		
		
		
		// 拥有的角色
		$adminRole = [];
		foreach($admin -> roles -> toArray() as $value)
		{
			$adminRole[] = $value['name'];
		}
		$this -> assign('adminRole', $adminRole);
		
		
		return $this -> fetch();
    }
	
	
    public function center()
    {
		return $this -> fetch();
    }
	
	
}
















