<?php
namespace app\common\model;

use think\Model;

class Pays extends Model
{
	public function getCreateTimeAttr($value)
    {
        return get_date($value);
    }
}
