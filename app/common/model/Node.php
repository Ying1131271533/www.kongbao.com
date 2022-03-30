<?php
namespace app\common\model;

use think\Model;

class Node extends Model
{
	public function setNameAttr($value)
    {
        return strtolower($value);
    }
	
	public function getNameAttr($value)
    {
		return strtolower($value);
	}
	
	public function roles()
    {
        return $this -> belongsToMany('Role', 'RoleNode');
    }
	
}
