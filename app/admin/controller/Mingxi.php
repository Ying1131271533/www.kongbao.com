<?php
namespace app\admin\controller;

use app\common\model\Mingxi as M;

class Mingxi extends Base
{
	public function index()
	{
		$uid = input('uid/d', 0);
		$type = input('type/d', 0);
		
		$this -> assign('uid', $uid);
		$this -> assign('type', $type);
		return $this -> fetch();
		
    }
	
	function index_data()
	{
		$uid = input('uid/d');
		$type = input('type/d');
		$field = input('field/s');
		$sort = input('order/s');
		$limit = input('limit/d', 50);
		
		$where = [];
		$order = [];
		
		
		
		! empty($uid) and $where[] = ['a.user_id', '=', $uid];
		! empty($type) and $where[] = ['a.type', '=', $type];
		! empty($field) ? $order['a.'.$field] = $sort : $order['a.id'] = 'DESC';
		
		$count = M::alias('a') -> join('user b', 'a.user_id= b.id') -> where($where) -> count();
		
		$list = M::alias('a')
		-> join('user b', 'a.user_id= b.id')
		-> field('a.*, b.username')
		-> where($where)
		-> order($order)
		-> paginate($limit)
		-> toArray();
		// dump($count);dump($list);return;
		
		if($list){
			$r['code'] = '0';
			$r['msg'] = '成功';
			$r['count'] = $count;
			$r['data'] = $list['data'];
		}else{
			$r['code'] = '500';
			$r['msg'] = '暂无数据';
			$r['count'] = '';
			$r['data'] = '';
		}
		
		return $r;
	}

	
}
