<?php
namespace app\web\validate;

use think\Validate;

class Account extends Validate
{
	protected $regex = [ 'alipay' => '/^1[23456789]\d{9}|[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/'];
	
	protected $rule = [
        'name'  	=>	'require|length:2,12|chs',
        'alipay'	=>	'require|regex:alipay',
    ];
    
    protected $message = [
        'name.require' 			=>	'真实姓名不能为空',
        'name.length'		    =>	'真实姓名格式有误',
        'name.chs'		    	=>	'真实姓名必须汉字',
        'alipay.require'        =>	'支付宝账号不能为空',
        'alipay.regex'       	=>	'支付宝账号格式错误',
    ];
}
