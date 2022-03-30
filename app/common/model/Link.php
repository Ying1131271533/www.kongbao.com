<?php
namespace app\common\model;

use think\Model;

class Link extends Model
{
    public function getCreateTimeAttr($value)
    {
        return get_date($value);
    }

}
