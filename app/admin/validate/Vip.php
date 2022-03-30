<?php
namespace app\admin\validate;

use think\Validate;

class Vip extends Validate
{
	 protected $rule = [
        'level2|黄金会员'  => 'max:8|min:1|number',
        'level3|铂金会员'  => 'max:8|min:1|number',
        'level4|钻石会员'  => 'max:8|min:1|number',
    ];
    
    protected $message = [
        'level2.max' => '最多8位字符',
        'level3.max' => '最多8位字符',
        'level4.max' => '最多8位字符',
        'level2.number' => '只能是数字',
        'level3.number' => '只能是数字',
        'level4.number' => '只能是数字',

    ];
}
