<?php
namespace app\admin\validate;

use think\Validate;

class Role extends Validate
{
	protected $rule = [
        'name|角色名称'  		=> 'require|unique:role',
        'explain|角色说明'   	=> 'require|unique:role',
    ];
    
    protected $message = [
        'name.require' 			=> '角色名称必须',
        'name.unique' 			=> '角色名称已存在',
		'explain.require'		=> '角色说明必须',
		'explain.unique'		=> '角色说明已存在',
    ];
}
