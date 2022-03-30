<?php
namespace app\admin\controller;
use app\common\model\User as U;
use app\common\model\Pays as Ps;
use think\facade\Db;
class Pays extends Base
{
	//支付宝充值记录页面
	public function index()
	{
		$number = input('number/d', 0);
		$status = input('status/d', 0);
		
		$this -> assign('number', $number);
		$this -> assign('status', $status);
		return $this -> fetch();
	} 
	//支付宝充值列表
	function index_data()
	{
		$number = input('number/s');
		$status = input('status/d', 0);
		$field = input('field/s');
		$sort = input('order/s');
		$limit = input('limit/d', 20);
		
		$where = [];
		$order = [];
		
		! empty($number) and $where[] = ['order', '=', $number];
		! empty($status) and $where[] = ['status', '=', $status];
		
		$count = Ps:: where($where) -> count();
		$list = Ps:: where($where) -> order('create_time DESC') -> paginate($limit) -> toArray();
		
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

		return $data;
	}
		
}