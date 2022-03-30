<?php
namespace app\web\validate;

use think\Validate;

class Tixian extends Validate
{
	 protected $rule = [
        'money'  	=>	'require|number|egt:10',
        'alipay'  	=>	'require',
        'name'    	=>	'require',
    ];
    
    protected $message = [
        'money.require' 	=> '提现金额不能为空',
        'money.number'   	=> '提现金额只能是整数',
        'money.egt'      	=> '提现金额不能小于10元',
        'alipay.require' 	=> '绑定提现账号后方可提现',
        'name.require'   	=> '你还未绑定提现账号',
    ];
}
