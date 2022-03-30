<?php
namespace app\admin\controller;

use app\common\model\Reward as R;
use app\common\model\user as U;
use app\common\model\Mingxi as M;
use think\facade\Db;
use think\Facade;
use think\facade\Request;

class Reward extends Base
{
	//邀请好友奖励列表
	public function index(){
		$user_id = input('user_id/d');
		$username = input('username/s');
		$number = input('number/d');
		$status = input('status/d', 0);
		
		$this -> assign('user_id', $user_id);
		$this -> assign('username', $username);
		$this -> assign('number', $number);
		$this -> assign('status', $status);
		return $this -> fetch();
	}
	
	//邀请奖励数据列表
	public function index_data(){

		$user_id = input('user_id/d');
		$username = input('username/s');
		$number = input('number/s');
		$status = input('status/d', 0);
		$field = input('field/s');
		$sort = input('order/s');
		$limit = input('limit/d', 20);
		
		$where = [];
		$order = [];
		
		! empty($user_id) and $where[] = ['a.id', '=', $user_id];
		! empty($username) and $where[] = ['b.username', 'like', '%'.$username.'%'];
		! empty($status) and $where[] = ['a.status', '=', $status];
		! empty($field) ? $order['a.' . $field] = $sort : $order['a.id'] = 'DESC';
		
		$count = R::alias('a') -> join('user b','b.id=a.user_id') -> where($where) -> count();
		$list = R::alias('a') -> join('user b','b.id=a.user_id') -> field('a.*,b.username,b.award_money') -> where($where) -> order($order) -> paginate($limit) -> toArray();
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

	//邀请奖励审核发放
	public  function edit(){
		Db::startTrans();

		$id = input('id/d');
		$status = input('status/d');

		if($status ==2){
		$pay = R::find($id);
		$pay -> status = $status;
		$pay -> dispose_time = time();
		$result = $pay -> save();
		if(!$result){
			Db::rollback();
			return $this -> error('审核失败');
		}

		$where['a.id']  = $id;
		$pays = R::alias('a') -> join('user b','b.id=a.user_id') -> field('a.*,b.username,b.award_money') -> where($where) -> order('create_time desc' )->select()-> toArray();
		if(!$pays){
			Db::rollback();
			return $this -> error('审核失败1');
		}
		//邀请人加钱
		$user_xuid  = U::find($pays[0]['xuid']);
		$user_xuid -> money 		 = $user_xuid['money']+$pay['jd_money'];
		$user_xuid -> frost_money = $user_xuid['frost_money']-$pay['jd_money'];//减掉冻结金额
		$user_result = $user_xuid -> save();

		if(!$user_result){
			Db::rollback();
			return $this -> error('审核失败2');
		}

		//被邀请人减钱
		$user_user_id  = U::find($pays[0]['user_id']);
		$user_user_id -> award_money = $pays[0]['award_money'] -$pays[0]['consume_money'];
		$user_user_id -> frost_money = $user_xuid['frost_money']-$pay['jd_money'];
		$user_result_user_user_id = $user_user_id -> save();
		if(!$user_result_user_user_id){
			Db::rollback();
			return $this -> error('审核失败3');
		}
		$pay -> jd_money =$pay['jd_money'] - $pay['jd_money'];
		$pay_jd_money_result = $pay -> save();
		if(!$pay_jd_money_result){
			Db::rollback();
			return $this -> error('审核失败4');
		}

			//邀请人添加明细
			$mingxi_where['id'] = $pays[0]['xuid'];
			$user_xuid_mingxi  = U::where($mingxi_where)->select()-> toArray();
			$data = [
				'money' 		 => $pays[0]['jd_money'],
				'status' 		 => 2,
				'type' 			 => 9,
				'zmoney'    	 => $user_xuid_mingxi[0]['money']+$pays[0]['jd_money'],
				'ip' 			 => get_ip(),
				'create_time'    => time(),
				'user_id'		 => $user_xuid['id'],
			];
			$article = new M;
			$mingxiresult = $article -> save($data);
			if(!$mingxiresult){
				Db::rollback();
			return $this -> error('审核失败5');
			}

		Db::commit();
		return $this -> success('审核成功','reward/index');


	}

	
}
}