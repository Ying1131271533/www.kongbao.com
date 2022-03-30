<?php
namespace app\web\validate;

use think\Validate;

class Address extends Validate
{
	protected $regex = [
		'phone' 				=>	'/^1[23456789]\d{9}$|0\d{2,3}-\d{5,9}$|\d{10}$/',
		'postcode' 				=>	'/^[0-9]{4,7}$/',
	];
	
	protected $rule = [
        'addresser|发货人'  	=>	'require|length:2,10',
        'phone|电话'  			=>	'require|regex:phone',
        'province|省份'    		=>	'require|length:2,10',
        'city|城市'    			=>	'require|length:2,10',
        'county|城区'    		=>	'require|length:2,10',
        'address|详细地址'    	=>	'require|length:5,100',
        'postcode|邮编'    		=>	'require|regex:postcode',
    ];
    
    protected $message = [
        'addresser.require' 	=>	'发货人不能为空',
        'addresser.length' 		=>	'发货人格式错误',
        'phone.regex' 			=>	'电话格式错误',
        'province.require' 		=>	'省份不能为空',
        'province.length' 		=>	'省份格式错误',
        'city.require' 			=>	'城区不能为空',
        'city.length' 			=>	'城区格式错误',
        'address.require' 		=>	'详细地址不能为空',
        'address.length' 		=>	'详细地址格式错误',
        'postcode.require' 		=>	'邮编不能为空',
        'postcode.regex' 		=>	'邮编格式错误',
    ];
	
}
