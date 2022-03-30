<?php
namespace app\common\model;

use think\Model;

class Admin extends Model
{
	// 保存时 密码进行md5加密
	public function setPasswordAttr($value)
	{
		return md5($value);
	}
	
	public function roles()
    {
        return $this -> belongsToMany('Role');
    }
	
	public function articles()
    {
        return $this -> hasMany('Article');
    }
}
