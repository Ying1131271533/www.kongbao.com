<?php
namespace app\common\model;

use think\Model;

class Order extends Model
{
	public function getCreateTimeAttr($value)
    {
        return get_date($value);
    }
	
	public function getDisposeTimeAttr($value)
    {
        return get_date($value);
    }
}
