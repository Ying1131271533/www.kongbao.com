<?php
namespace app\admin\validate;

use think\Validate;

class Login extends Validate
{
	 protected $rule = [
        'name'  		=> 'require|length:4,18',
        'password'   	=> 'require|min:6',
    ];
    
    protected $message = [
        'name.require' 			=> '名称不能为空',
		'name.length'			=> '名称为4至18个字符',
        'password.require'   	=> '密码不能为空',
        'password.min'   		=> '密码不能少于6位',
    ];
}
