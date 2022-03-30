<?php
namespace app\admin\controller;
use app\common\model\User as U;
use app\common\model\Pay as P;
use app\common\model\Pays as Ps;
use app\common\model\Mingxi as M;
use app\common\model\Reward as R;
use think\facade\Db;
class Pay extends Base
{
	//充值记录页面
	public function index()
	{
		$user_id = input('user_id/d');
		$username = input('username/s');
		$number = input('number/d');
		$status = input('status/d', 0);
		
		// dump(input());return;
		
		$this -> assign('user_id', $user_id);
		$this -> assign('username', $username);
		$this -> assign('number', $number);
		$this -> assign('status', $status);
		return $this -> fetch();
	} 
	//会员充值列表
	function index_data()
	{
		$user_id = input('user_id/d');
		$username = input('username/s');
		$number = input('number/s');
		$status = input('status/d', 0);
		$field = input('field/s');
		$sort = input('order/s');
		$limit = input('limit/d', 20);
		
		$where = [];
		$order = [];
		
		! empty($user_id) and $where[] = ['a.user_id', '=', $user_id];
		! empty($number) and $where[] = ['a.order', '=', $number];
		! empty($username) and $where[] = ['b.username', 'like', '%'.$username.'%'];
		! empty($status) and $where[] = ['a.status', '=', $status];
		! empty($field) ? $order['a.' . $field] = $sort : $order['a.id'] = 'DESC';
		
		$count = P::alias('a') -> join('user b', 'a.user_id=b.id') -> where($where) -> count();
		$list = P::alias('a') -> join('user b', 'a.user_id=b.id') -> field('a.*,b.username') -> where($where) -> order($order) -> paginate($limit) -> toArray();
		
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
		
		return json($data);
	}
	
	//会员充值审核确认
	function edit()
	{
		Db::startTrans();
		$id = input('id/d');
		$status = input('status/d');
		
		//修改充值订单状态	
		$pay = P::find($id);
		$pay -> status = $status;
		$pay -> check_time = time();
		$result = $pay -> save();

		if($result !== true){
			Db::rollback();
			return $this -> error('审核失败1');
		}
		$pay['money'] = intval($pay['money']);
		//审核通过
		if($status == 2){
			//增加用户金额
			$userdata = U::find($pay['user_id']);
						$userdata -> money     	= $userdata['money']+(int)$pay['money'];
						$result = $userdata -> save();
			if(!$result){
				Db::rollback();
				return $this -> error('审核失败2');
			}

			//一次性充值达到额度，直接奖励会员等级
			if($pay['money']>=188 && $pay['money']<388){
				if($userdata['level']==1){
					$userdata->where(array('id'=>$pay['user_id']))->save(array('level'=>2));
				}	
			}elseif($pay['money']>=388 && $pay['money']<588){
				if($userdata['level']<=2){
					$userdata->where(array('id'=>$pay['user_id']))->save(array('level'=>3));
				}
			}elseif($pay['money']>=588){
				if($userdata['level']<=3){
					$userdata->where(array('id'=>$pay['user_id']))->save(array('level'=>4));
				}
			}

			//添加明细
			$data = [
				'money' 		 => $pay['money'],
				'status' 		 => 2,
				'type' 			 => 3,
				'zmoney'    	 =>$userdata['money'] ,
				'ip' 			 => get_ip(),
				'create_time'    =>time() ,
				'user_id'		 =>$pay['user_id'] ,
			];
			$article = new M;
			$mingxiresult = $article -> save($data);
			if(!$mingxiresult){
				Db::rollback();
				return $this -> error('审核失败3');
			}

			//充值奖励
			if($userdata['id']>0 && $pay['money']>=100){
		
				if($pay['money']>=100 && $pay['money']<300){
					//充值100以上 奖6元
					$add['money'] = 100;
					$add['jd_money'] = 6;
				}elseif($pay['money']>=300 && $pay['money']<500){
					//充值300以上 奖20元
					$add['money'] = 300;
					$add['jd_money'] = 20;
				}elseif($pay['money']>=500 && $pay['money']<1000){
					//充值500以上 奖40元
					$add['money'] = 500;
					$add['jd_money'] = 40;
				}elseif($pay['money']>=1000){
					//充值1000以上 奖励100
					$add['money'] = 1000;
					$add['jd_money'] = 100;
				}
				//增加冻结金额
							$recommend_id['id'] = $pay['user_id'];
						 $userdata_xuids = U::field('id,recommend_id') -> where($recommend_id)->select()-> toArray();
						 
						 $where_users['id'] = $userdata_xuids[0]['recommend_id'];

						 $express = U::find($where_users);
						$userdata_xuid = U::where($where_users)->select()-> toArray();
						$express -> frost_money = $userdata_xuid[0]['frost_money']+(int)$add['jd_money'];
						$jieg = $express -> save();
				if(!$jieg){
					Db::rollback();
					return $this -> error('审核失败4');
				}
				$jdmoney = $add['jd_money'];

				if(!$jdmoney == 0){
					$add = new R;
					$add-> xuid 			= $userdata['recommend_id'];
					$add-> consume_money    = $pay['money'];
					$add-> jd_money 		= $jdmoney;
					$add-> pay_money 		= $pay['money'];
					$add-> status 			= 1;
					$add-> create_time 		= time();
					$add-> user_id 			= $userdata['id'];
					//插入奖励记录
					$Reward_result = $add -> save();
					if(!$Reward_result){
						Db::rollback();
						return $this -> error('审核失败5');
					}
				}
			}
			Db::commit();
			return $this -> success('审核成功');
		}
			
		
	}
	//会员充值确认不通过
	public function pay_edit(){
		$id = input('id/d');
		$Pays = P::find($id);
			if (request() -> isPost()) {
				$id = input('id/d');
				$failure = input('failure');
				$status = input('status/d');
				//修改充值订单状态
				$pay = P::find($id);
				$pay -> status = $status;
				$pay -> check_time = time();
				$pay -> msg = $failure;

				$result = $pay -> save();
				if ($result) {
					return $this -> error('失败原因已提交');
				}else{
					return $this -> error('审核失败1');

				}

				
		}
		$this -> assign('list', $Pays);
		return $this -> fetch();
	}

		
}