<?php
namespace app\web\validate;

use think\Validate;

class Bag extends Validate
{
	protected $regex = [
		'kd_id' => '/^\d{1,3}$/',
		'phone' => '/^[0-9_-]{5,18}$/',
		'postcode' => '/^[0-9]{4,10}$/',
		'kg' => '/^[0-9\.]{1,9}$/',
	];
	
	protected $rule = [
        'kd_id|快递公司'				=>	'require|regex:kd_id',
        'address_id|发货地址'			=>	'require',
		
        'sname|收货人名字'  			=>	'require|length:2,20',
        'sprovince|收货人省份'  		=>	'require|length:2,13',
        'scity|收货人城市'  			=>	'require|length:2,13',
        'scounty|收货人市区'  			=>	'require|length:2,13',
        'saddress|收货人详细地址'  		=>	'require|length:5,100',
        'sphone|收货人的电话'  			=>	'require|regex:phone',
		
        'goods_name|物品名称'  			=>	'require|length:1,20',
        'kg|物品重量'  					=>	'require|regex:kg',
    ];
    
    protected $message = [
        'kd_id.require' 				=>	'快递公司不能为空',
        'kd_id.regex' 					=>	'快递公司有误',
		
        'address_id.require'		    =>	'发货地址不能为空',
		
        'sname.require'		    		=>	'收货人名字不能为空',
        'sname.length'		    		=>	'收货人名字格式有误',
        'sprovince.require'		    	=>	'收货人省份不能为空',
        'sprovince.length'		    	=>	'收货人省份格式有误',
        'scity.require'		    		=>	'收货人城市不能为空',
        'scity.length'		    		=>	'收货人城市格式有误',
        'scounty.require'		    	=>	'收货人市区不能为空',
        'scounty.length'		    	=>	'收货人市区格式有误',
        'saddress.require'		    	=>	'收货人详细地址不能为空',
        'saddress.length'		    	=>	'收货人详细地址格式有误',
        'sphone.require'		    	=>	'收货人的电话不能为空',
        'sphone.regex'		    		=>	'收货人的电话格式有误',
        'goods_name.require'		    =>	'物品名称不能为空',
        'goods_name.length'		    	=>	'物品名称格式有误',
        'kg.require'		    		=>	'物品重量不能为空',
        'kg.regex'		    			=>	'物品重量格式有误',
    ];
	
	
	protected $scene = [
        'edit'  	=>  ['sname', 'sphone', 'sprovince', 'scity', 'scounty', 'saddress'],
    ];
}























