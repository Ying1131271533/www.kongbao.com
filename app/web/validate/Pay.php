<?php
namespace app\web\validate;

use think\Validate;

class Pay extends Validate
{
	 protected $rule = [
        'order'  		=>'require|checkLength:order|number|unique:pay',
        'money'         =>'require',
    ];
    
    protected $message = [
        'order.require' 			=> '订单号不能为空',
        'order.number' 				=> '订单号只能为数字',
        'order.unique' 				=> '订单号已提交过',
        'money.require'             => '充值金额不能为空',
    ];
	
	
	protected function checkLength($order)
	{
		$length = strlen($order);
		if($length === 28 || $length === 32)
		{
			return true;
		}
		return '订单号必须是28位或者32位。';
	}
}
