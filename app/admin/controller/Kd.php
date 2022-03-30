<?php
namespace app\admin\controller;

use app\common\model\Kd as K;

class Kd extends Base
{
	//快递列表页面
	public function index()
	{
		$ms = input('ms/d', 0);
		if(request() -> isAjax())
		{
			$name = input('name/s');
			$field = input('field/s');
			$sort = input('order/s');
			$limit = input('limit/d', 20);
			
			// dump(input());return;
			
			$where = [];
			$order = [];
			
			! empty($ms) and $where[] = ['ms', '=', $ms];
			! empty($name) and $where[] = ['name', 'like', '%'.$name.'%'];
			! empty($field) ? $order[$field] = $sort : $order['id'] = 'DESC';
			
			// dump($where);
			// dump($order);
			// return;
			
			$count = K::where($where) -> count();
			$list = K::where($where) -> order($order) -> paginate($limit) -> toArray();
			// dump($list);
			// return;
			
			if($list)
			{
				$data['code'] = '0';
				$data['msg'] = '成功';
				$data['count'] = $count;
				$data['data'] = $list['data'];
			}else
			{
				$data['code'] = '500';
				$data['msg'] = '暂无数据';
				$data['count'] = '';
				$data['data'] = '';
			}
			// dump($data);return;
			return $data;
		}
		
		$this -> assign('ms', $ms);
		return $this -> fetch();
	}
	
	//快递添加页面
	public function add()
	{
		if(request() -> isPost())
		{
			$data = [
				'name' => input('name'),
				'explain' => input('explain'),
				'image' => input('image'),
				'status' => input('status'),
				'type' => input('type'),
				'ms' => input('ms'),
				'apitype' => input('apitype'),
				'sort_order' => input('sort_order'),
				'level1' => input('level1'),
				'level2' => input('level2'),
				'level3' => input('level3'),
				'level4' => input('level4'),
				'cost_price' => input('cost_price'),
				'create_time' => time(),
			];
			
			$Kd = new K;
			$result = $Kd -> save($data);
			if(empty($result))
			{
				return $this -> error('添加失败', url('add'));
			}
			
			
			return $this -> success('添加成功', url('index'));
		}
		
		return $this -> fetch();
	}
	
	//快递修改页面
	public function edit()
	{
		$id = input('id');
		$express = K::find($id);
		
		if(request() -> isPost())
		{
			$data = [
				'name' => input('name'),
				'explain' => input('explain'),
				'image' => input('image'),
				'status' => input('status'),
				'type' => input('type'),
				'ms' => input('ms'),
				'apitype' => input('apitype'),
				'sort_order' => input('sort_order'),
				'level1' => input('level1'),
				'level2' => input('level2'),
				'level3' => input('level3'),
				'level4' => input('level4'),
				'cost_price' => input('cost_price'),
				'create_time' => time(),
			];
			
			$result = $express -> save($data);
			if(empty($result))
			{
				return $this -> error('保存失败', url('add'));
			}
			
			
			return $this -> success('保存成功');
		}
		
		$this -> assign('express', $express);
		return $this -> fetch();
		
	}
	
	
	//快递页面删除
	public function del()
	{
		$id = input('id');
		$result = K::destroy($id);
		if($result !== true)
		{
			return $this -> error('操作失败', url('index'));
		}
		
		return $this -> success('删除成功', url('index'));
		
	}

	
}
