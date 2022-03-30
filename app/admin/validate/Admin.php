<?php
namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
	 protected $rule = [
        'name'  		=> 'require|length:4,18|unique:admin',
        'password'   	=> 'require|min:6|confirm:password2',
        'qq'   			=> 'min:6|max:11|number',
        'real_name'   	=> 'require',
    ];
    
    protected $message = [
        'name.require' 			=> '名称必须',
		'name.length'			=> '名称为4至18个字符',
		'name.unique'			=> '名称已存在',
		'real_name.require'		=> '真实姓名必须',
        'password.require'   	=> '密码必须',
        'password.min'   		=> '密码不能少于6位',
        'password.confirm'   	=> '两次密码不一致',
        'qq.min'   				=> 'qq不能少于6位',
        'qq.number'   			=> 'qq必须是数字',
        'qq.max'   				=> 'qq不能大于11位',
    ];
	
	
}
