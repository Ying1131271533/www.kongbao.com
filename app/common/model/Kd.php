<?php
namespace app\common\model;

use think\Model;

class Kd extends Model
{
	public function numbers()
    {
        return $this -> hasMany('Numbers');
    }
	
	public function bag()
    {
        return $this -> hasMany('Bag');
    }
}
