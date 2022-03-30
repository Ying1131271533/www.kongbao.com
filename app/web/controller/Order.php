<?php
namespace app\web\controller;

use app\common\model\Bag as B;
use app\common\model\Pay as P;
use app\common\model\Order as O;
use app\common\model\User as U;

class Order extends Base
{		
	// 申请底单
    public function index()
	{
		if(request() -> isPost())
		{
			// dump(input());return;
			
			$order = O::where('number', input('number')) -> where('status', 'in', '1,2') -> count();
			if(! empty($order))
			{
				return $this -> akali('此单号已申请过');
			}
			
			$where[] = ['id', '=', session('userid')];
			$user = U::field('level,money') -> where($where) -> find();
			if($user['level'] == 1)
			{
				if($user['money'] < '0.5')
				{
					return $this -> akali('当前可以余额不足，普通会员申请底单需要0.5元每份！');
				}
			}
			
			
			$data['kdname'] = input('kdname');
			$data['number'] = input('number');
			$data['fname'] = input('fname');
			$data['fphone'] = input('fphone');
			$data['faddress'] = input('faddress');
			$data['sname'] = input('sname');
			$data['sphone'] = input('sphone');
			$data['saddress'] = input('saddress');
			$data['ftime'] = strtotime(input('ftime'));
			$data['goods_name'] = input('goods');
			$data['kg'] = input('kg');
			$data['create_time'] = time();
			$data['image'] = input('image');
			$data['status'] = 1;
			$data['user_id'] = session('userid');
			$data['kd_id'] = input('kd_id/d');
			
			
			
			$valiResult = $this -> validate($data, 'Order');
			if($valiResult !== true)
			{
				return $this -> akali($valiResult);
			}
			
			
			// 开启事务
			U::startTrans();
			
			if($user['level'] == 1)
			{
				// 金额是否足够
				if($user['money'] < 0.5)
				{
					return $this -> akali('当前可以余额不足，普通会员申请底单需要0.5元每份！');
				}
				
				
				$mxData = mingxi_add(1, 11, 0.5, $user['money'],  $user['id']);
				$mingxi = $user -> mingxis() -> save($mxData);
				
				
				
				// 减少可用余额 - 增加消费金额 - 增加消费奖励金额
				$moneyResult = U::where('id', session('userid')) -> dec('money', 0.5) -> save();
				$expense_money = U::where('id', session('userid')) -> inc('expense_money', 0.5) -> save();
				$award_money = U::where('id', session('userid')) -> inc('award_money', 0.5) -> save();
				if(empty($moneyResult) || empty($expense_money) || empty($award_money))
				{
					U::rollback();
					return $this -> akali('购买超时，请重新提交');
				}
				
			}
			
			// 空包保存
			$bag = $user -> orders() -> save($data);
			if(empty($bag))
			{
				U::rollback();
				return $this -> akali('购买超时，请重新提交');
			}
			
			
			
			U::commit();
			return $this -> akali('提交申请成功，客服将在24小时内处理完成', url('record'));
		}
		
		return $this -> fetch();
	}
	
	// 获取单号信息
	function bag_info()
	{
		if(request() -> isPost())
		{
			$number = input('number/s');
			
			
			$where = [];
			
			
			$where[] = ['a.user_id', '=', session('userid')];
			$where[] = ['a.number', '=', $number];
			$where[] = ['a.status', 'in', '1,2'];
			
			$kddata = B::alias('a')
					-> join('kd b', 'a.kd_id=b.id')
					-> join('address d', 'a.address_id=d.id')
					-> field('a.*,d.*,b.name as kd_name,d.*')
					-> where($where)
					-> find();
			
			// $time = $kddata -> getData('time');
			// dump($kddata);return;
			if(empty($kddata))
			{
				$kddata['code'] = 1;
				return $kddata;
			}
			
			$time_date = $kddata -> getData('time');
			$kddata['time_date'] = date('Y-m-d', $time_date);
			$kddata['code'] = 0;
			return $kddata;
		}
	}
	
	// 底单列表
	function record()
	{
		$list = O::where('user_id', session('userid'))
				-> where('create_time', '>', time() - 86400 * 30)
				-> order('id DESC')
				-> paginate(20);
		$page = $list -> render();
		
		
		$this -> assign('list', $list);
		$this -> assign('page', $page);
		return $this -> fetch();
	}
	
	// 底单信息
	function view()
	{
		$id = input('id/d');
		$list = O::find($id);
		
		$this -> assign('list', $list);
		return $this -> fetch();
	}
	
}


















