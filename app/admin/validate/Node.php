<?php
namespace app\admin\validate;

use think\Validate;

class Node extends Validate
{
	 protected $rule = [
        'name|节点地址'  		=> 'require|unique:node',
        'title|节点名称'   		=> 'require|unique:node',
    ];
    
    protected $message = [
        'name.require' 			=> '节点地址必须',
        'name.unique' 			=> '节点地址已存在',
		'title.require'			=> '节点名称必须',
		'title.unique'			=> '节点名称已存在',
    ];
}
