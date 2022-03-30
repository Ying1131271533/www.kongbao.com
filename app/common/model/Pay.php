<?php
namespace app\common\model;

use think\Model;

class Pay extends Model
{
	public function user()
    {
        return $this -> belongsTo('User');
    }
	
	public function getCreateTimeAttr($value)
    {
        return get_date($value);
    }
	
	public function getCheckTimeAttr($value)
    {
        if(empty($value))
		{
			return '';
		}
		
		return get_date($value);
    }
}
