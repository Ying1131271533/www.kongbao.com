<?php
namespace app\common\model;

use think\Model;

class ArticleType extends Model
{
	public function articles()
    {
		return $this -> hasMany('Article', 'type_id');
    }
}
