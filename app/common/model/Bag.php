<?php
namespace app\common\model;

use think\Model;

class Bag extends Model
{
	public function getTimeAttr($value)
    {
        return get_date($value);
    }
}
