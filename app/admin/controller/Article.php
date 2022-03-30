<?php
namespace app\admin\controller;

use app\common\model\Article as A;
use app\common\model\ArticleType as At;

class Article extends Base
{
	/* 文章分类 */
	function type_add()
	{
		if(request() -> isPost())
		{
			$data = [
				'name' => input('name/s'),
				'create_time' => time(),
			];
			$article = new AT;
			$result = $article -> save($data);
			if(empty($result))
			{
				return $this -> error('添加失败');
			}
			
			return $this -> success('添加成功', url('article/type'));
		}
		
		return $this -> fetch();
	}
	
	public function type()
	{
		$type = At::select();
		$this -> assign('type', $type);
		return $this -> fetch();
	}
	
	public function type_edit()
	{
		$id = input('id/d');
		$type = At::find($id);
		if(request() -> isPost())
		{
			$data = [
				'name' => input('name/s'),
			];
			
			$result = $type -> save($data);
			if($result !== true)
			{
				return $this -> error('保存失败');
			}
			
			return $this -> success('保存成功');
		}
		
		$this -> assign('type', $type);
		return $this -> fetch();
	}
	
	public function type_del()
	{
		$id = input('id/d');
		$type = At::find($id);
		$result = $type -> delete();
		if($result !== true)
		{
			return $this -> error('删除失败');
		}
		
		return $this -> success('删除成功');
	}
	
	/* 文章 */
	function add()
	{
		if(request() -> isPost())
		{
			// dump(input());
			// return;
			
			$data = [
				'title' => input('title/s'),
				'content' => input('content/s'),
				'admin_id' => session('admin.id'),
				'type_id' => input('type_id/d'),
				'sourec_title' => input('sourec_title/s'),
				'status' => input('status/d'),
				'sourec_url' => input('sourec_url/s'),
				'create_time' => time(),
			];
			
			$valiResult = $this -> validate($data, 'Article');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			$type = At::find($data['type_id']);
			
			$result = $type -> articles() -> save($data);
			if(empty($result))
			{
				return $this -> error('保存失败');
			}
			
			return $this -> success('保存成功', url('article/index'));
		}
		
		$type = At::select();
		$this -> assign('type', $type);
		
		return $this -> fetch('add-layui');
		// return $this -> fetch('add-baidu');
	}
	
	public function index()
	{
		$type = input('type/d', 0);
		$typeList = At::select();
		
		$this -> assign('type', $type);
		$this -> assign('typeList', $typeList);
		
		return $this -> fetch();
	}
	
	function index_data()
	{
		$type = input('type');
		$field = input('field');
		$sort = input('order');
		
		$limit = input('limit/d', 20);
		
		
		$where = [];
		$order = [];
		
		! empty($type) and $where[] = ['a.type_id', '=', $type];
		! empty($field) ? $order['a.'.$field] = $sort : $order['a.id'] = 'desc';
		
		
		// 查询分类 所拥有的文章状态不等于1 暂时用不到
		// $article = At::hasWhere('articles', ['status' => 1]) -> select();
		$count = A::alias('a') -> join('article_type b', 'a.type_id=b.id') -> where($where) -> count();
		$list = A::alias('a') -> join('article_type b', 'a.type_id=b.id') -> field('a.*, b.name as type') -> where($where) -> order($order) -> paginate($limit)-> toArray();
		
		$data = [
			'code' => '0',
			'msg' => '成功',
			'count' => $count,
			'data' => $list['data'],
		];
		
		if(empty($list))
		{
			$data = [
				'code' => '500',
				'msg' => '暂无数据',
				'count' => '',
				'data' => '',
			];
		}
		
		return $data;
	}
	
	function edit()
	{
		$id = input('id/d');
		$article = A::find($id);
		if(request() -> isPost())
		{
			// dump(input());
			// return;
			
			$data = [
				'title' => input('title/s'),
				'content' => input('content/s'),
				'admin_id' => session('admin.id'),
				'type_id' => input('type_id/d'),
				'sourec_title' => input('sourec_title/s'),
				'status' => input('status/d'),
				'sourec_url' => input('sourec_url/s'),
			];
			
			$valiResult = $this -> validate($data, 'Article');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			$result = $article -> save($data);
			if($result !== true)
			{
				return $this -> error('保存失败');
			}
			
			return $this -> success('保存成功');
		}
		
		$type = At::select();
		$this -> assign('type', $type);
		$this -> assign('article', $article);
		
		return $this -> fetch('edit-layui');
		// return $this -> fetch('edit-baidu');
	}
	
	public function del()
	{
		$id = input('id/d');
		$article = A::find($id);
		$result = $article -> delete();
		if($result !== true)
		{
			return $this -> error('删除失败');
		}
		
		return $this -> success('删除成功');
	}
	
	
}
















