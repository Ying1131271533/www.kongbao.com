<?php
namespace app\admin\controller;

use app\common\model\User as U;
use app\common\model\Mingxi as M;

class User extends Base
{
	//会员列表
	public function index()
	{
		$id = input('id/d');
		$email = input('email/s');
		$username = input('username/s');
		
		$this -> assign('id', $id);
		$this -> assign('email', $email);
		$this -> assign('username', $username);
		return $this -> fetch();
	}
	
	// 会员数据
	public function index_data()
	{
		
		$id = input('id/d');
		$email = input('email/s');
		$username = input('username/s');
		$field = input('field/s');
		$sort = input('order/s');
		
		// layui 参数
		$limit = input('limit/d', 50);
		
		$where = [];
		$order = [];
		
		! empty($id) and $where[] = ['id', '=', $id];
		! empty($email) and $where[] = ['email','like',"%{$email}%"];
		! empty($username) and $where[] = ['username', 'like', "%{$username}%"];
		! empty($field) ? $order[$field] = $sort : $order['id'] = 'DESC';
		
		$count = U::where($where) -> count();
		$list = U::where($where) -> order($order) -> paginate($limit) -> toArray();
		
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
	
	
	public function edit()
	{
		$id = input('id/d');
		$user = U::find($id);
		if(request() -> isPost())
		{
			
			$udata['name'] = input('name');
			$udata['alipay'] = input('alipay');
			$udata['isvalid'] = input('isvalid');
			$udata['level'] = input('level'); //会员等级
			$udata['email'] = input('email');
			$udata['phone'] = input('phone'); //电话
			$udata['qq'] = input('qq'); //qq
			
			//密码为空不修改
			$password = input('password');
			if($password != ''){
				$udata['password'] = md5($password);
			}
			
			//修改会员数据
			$result = $user -> save($udata); 
			if(empty($result))
			{
				return $this -> error('修改失败');
			}
			
			//修改成功跳转至上一页面
			return $this -> success('修改成功');
		}
		
		$this -> assign('list', $user);
		return $this -> fetch();
	}

	
	public function refund()
	{
		
		if(request() -> isPost())
		{
			$id = input('uid');
			$money = input('tui');
			if(empty($money))
			{
				return $this -> error('金额不能为空');
			}
			
			U::where('id', $id) -> inc('money', $money) -> update(); //增加可用金额
			U::where('id', $id) -> dec('expense_money', $money) -> update(); //减少消费金额			
			
			//添加明细
			$user = U::find($id);
			
			$data['money'] = $money;
			$data['status'] = 2;
			$data['zmoney'] = $user['money'] + $money;
			$data['create_time'] = time();
			$data['type'] = 10;
			$data['ip'] = get_ip();
			$user -> mingxis() -> save($data);
			
			return $this -> success('退款成功', url('mingxi/index', ['uid' => $id]));
		}
	}
	
	
	
	
	
	
}
