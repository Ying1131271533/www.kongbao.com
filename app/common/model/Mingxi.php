<?php
namespace app\common\model;

use think\Model;

class Mingxi extends Model
{
	public function getTypeAttr($value)
    {
        return mingxi($value);
    }
	
	public function getCreateTimeAttr($value)
    {
        return get_date($value);
    }
}
