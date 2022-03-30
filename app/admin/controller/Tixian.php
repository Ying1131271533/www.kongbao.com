<?php
namespace app\admin\controller;
use app\common\model\Tixian as T;
use app\common\model\User as U;
use app\common\model\Mingxi as M;
use think\facade\Db;
class Tixian extends Base
{
	//会员提现页面
	public function index()
	{
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
	//会员提现列表数据
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
		
		! empty($user_id) and $where[] = ['a.id', '=', $user_id];
		! empty($username) and $where[] = ['b.username', 'like', '%'.$username.'%'];
		! empty($status) and $where[] = ['a.status', '=', $status];
		! empty($field) ? $order['a.' . $field] = $sort : $order['a.id'] = 'DESC';
		
		$count = T::alias('a') -> join('user b','b.id=a.user_id') -> where($where) -> count();
		$list = T::alias('a') -> join('user b','b.id=a.user_id') -> field('a.*,b.username,b.id as bid') -> where($where) -> order($order) -> paginate($limit) -> toArray();
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

		
	//会员提现审核确认
	function edit(){
		Db::startTrans();
		$id = input('id/d');
		$status = input('status/d');
            if ($status ==2) {
                $Tixian = T::find($id);
                $Tixian -> status = $status;
                $Tixian -> dispose_time = time();
                $result = $Tixian -> save();
                if (!$result) {
                    Db::rollback();
                    return $this -> error('提现失败1');
                }
                //提现成功减去冻结金额
                $userdata = U::find($Tixian['user_id']);
                $userdata-> frost_money     = $userdata['frost_money']-$Tixian['money'];
                $userresult = $userdata -> save();
                if (!$userresult) {
                    Db::rollback();
                    return $this -> error('提现失败2');
                }
                Db::commit();
                return $this -> success('提现成功');
            } 
	
		
	}

//会员提现审核确认不通过
	public function tixian_edit(){

		$id = input('id/d');
		$Tixians = T::find($id);

        if (request() -> isPost()) {
			Db::startTrans();
			$id = input('id/d');
			$failure = input('failure');
			$status = input('status/d');
                $Tixian = T::find($id);
                $Tixian -> status = $status;
				$Tixian -> dispose_time = time();
                $result = $Tixian -> save();
                if (!$result) {
                    Db::rollback();
                    return $this -> error('提现失败3');
                }
                //提现失败冻结金额归还到余额
				$userdatas = U::find($Tixian['user_id']);
				$userdatas -> failure_prompt1 = $failure;
                $userdatas-> money     		= $userdatas['money']+$Tixian['money'];
				$userdatas-> frost_money 	= $userdatas['frost_money']-$Tixian['money'];
                $userresults = $userdatas -> save();
                if ($userresults) {
                    Db::commit();
                    return $this -> error('失败原因已提交');
                }
            }
		$this -> assign('list', $Tixians);
		return $this -> fetch();
	}
			
		
}