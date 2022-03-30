<?php
namespace app\common\model;

use think\Model;

class User extends Model
{
	public function setPasswordAttr($value)
    {
        return md5($value);
    }
	
	public function getCreateTimeAttr($value)
    {
        return get_date($value);
    }
	
	public function white()
    {
        return $this -> hasOne('White');
    }
	
	public function address()
    {
        return $this -> hasMany('Address');
    }
	
	public function mingxis()
    {
        return $this -> hasMany('Mingxi');
    }
	
	public function orders()
    {
        return $this -> hasMany('Order');
    }
	
	public function pays()
    {
        return $this -> hasMany('Pay');
    }
	
	public function rewards()
    {
        return $this -> hasMany('Reward');
    }
	
	public function tixians()
    {
        return $this -> hasMany('Tixian');
    }

    public function bags()
    {
        return $this -> hasMany('Bag');
    }
}
