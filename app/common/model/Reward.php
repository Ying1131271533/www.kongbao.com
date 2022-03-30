<?php
namespace app\common\model;

use think\Model;

class Reward extends Model
{
	public function getCreateTimeAttr($value)
    {
        return get_date($value);
    }
	
	public function getDisposeTimeAttr($value)
    {
        if(empty($value))
		{
			return '';
		}
		
		return get_date($value);
    }
}
