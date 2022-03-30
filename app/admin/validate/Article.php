<?php
namespace app\admin\validate;

use think\Validate;

class Article extends Validate
{
	protected $rule = [
        'title|文章标题'			=> 'require',
        'type_id|文章分类'			=> 'require',
        'content|文章内容'			=> 'require',
    ];
    
    protected $message = [
        'title.require' 			=> '文章标题不能为空',
        'type_id.require' 			=> '文章分类不能为空',
        'content.require' 			=> '文章内容不能为空',
    ];
}
