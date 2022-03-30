<?php
namespace app\common\model;

use think\Model;

class Role extends Model
{
	public function nodes()
    {
        return $this -> belongsToMany('Node');
    }
	
	public function admins()
    {
		return $this->belongsToMany('Admin', 'AdminRole');
		// return $this->belongsToMany('Admin', '\\app\\common\\model\\AdminRole');
    }
}
