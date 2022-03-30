<?php
namespace app\web\validate;

use think\Validate;

class Order extends Validate
{
	protected $regex = [
		'phone' 						=> '/^[0-9_-]{5,18}$/',
		'kg' 							=> '/^[0-9\.]{1,9}$/',
	];
	
	protected $rule = [
        'kdname|快递名称'				=>	'require|min:2',
        'number|快递单号'				=>	'require',
		
        'fname|发货货人名字'  			=>	'require|length:2,20',
        'fphone|发货人的电话'  			=>	'require|regex:phone',
        'faddress|发货人地址'  			=>	'require|length:5,100',
		
        'sname|收货人名字'  			=>	'require|length:2,20',
        'sphone|收货人的电话'  			=>	'require|regex:phone',
        'saddress|收货人地址'  			=>	'require|length:5,100',
		
        'goods_name|物品名称'  			=>	'require|length:1,20',
        'kg|物品重量'  					=>	'require|regex:kg',
        'image|降权截图'  				=>	'require',
    ];
    
    protected $message = [
        'kdname.require' 				=>	'快递名称不能为空',
        'kdname.min' 					=>	'快递名称有误',
        'number.require'		    	=>	'快递单号不能为空',
		
        'fname.require'		    		=>	'发货人名字不能为空',
        'fname.length'		    		=>	'发货人名字格式有误',
        'fphone.require'		    	=>	'发货人的电话不能为空',
        'fphone.regex'		    		=>	'发货人的电话格式有误',
        'faddress.require'		    	=>	'发货人详细地址不能为空',
        'faddress.length'		    	=>	'发货人详细地址格式有误',
		
        'sname.require'		    		=>	'收货人名字不能为空',
        'sname.length'		    		=>	'收货人名字格式有误',
        'sphone.require'		    	=>	'收货人的电话不能为空',
        'sphone.regex'		    		=>	'收货人的电话格式有误',
        'saddress.require'		    	=>	'收货人详细地址不能为空',
        'saddress.length'		    	=>	'收货人详细地址格式有误',
        'goods_name.require'		    =>	'物品名称不能为空',
        'goods_name.length'		    	=>	'物品名称格式有误',
        'kg.require'		    		=>	'物品重量不能为空',
        'kg.regex'		    			=>	'物品重量格式有误',
        'image.require'		    		=>	'降权截图不能为空',
    ];
	
}























