<?php
namespace app\admin\validate;

use think\Validate;

class AdminEdit extends Validate
{
	 protected $rule = [
        'name'  		=> 'length:4,18|unique:admin',
        'password'   	=> 'min:6|confirm:password2',
        'qq'   			=> 'min:6|number',
    ];
    
    protected $message = [
        'name.require' 			=> '名称必须',
		'name.length'			=> '名称为4至18个字符',
		'name.unique'			=> '名称已存在',
        'password.min'   		=> '密码不能少于6位',
        'password.confirm'   	=> '两次密码不一致',
        'qq.min'   				=> 'qq不能少于6位',
        'qq.number'   			=> 'qq必须是数字',
    ];
	
}
