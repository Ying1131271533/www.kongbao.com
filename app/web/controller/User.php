<?php
namespace app\web\controller;

use app\common\model\User as U;
use app\common\model\Bag as B;
use app\common\model\Kd;
use app\common\model\Address as Ad;
use app\common\model\Vip as V;

class User extends Base
{
    public function index()
    {
		$where = [
			['status', '=', 1],
			['ms', 'in', '1,2,3'],
			['type', '=', 1],
		];
		$list = Kd::where($where) -> order('sort_order asc') -> select();
		$this -> assign('list', $list);
		$this -> assign('check', 0);
		
		$user = U::find(session('userid'));
		$address = $user -> address;
		$this -> assign('address', $address);
		
		return $this -> fetch();
    }
	
	// vip升级
	function vip()
	{
		if(request() -> isAjax())
		{
			// dump(input());return;
			$level = input('type/d');
			$vip = V::find();
			$user = U::find(session('userid'));
			$vipPrice = $vip['level'.$level];
			
			if($user['money'] < $vipPrice)
			{
				return ['code' => 1, 'msg' => '余额不足'];
			}
			
			// 开启事务
			U::startTrans();
			
			$user -> level = $level;
			$result = $user -> save();
			if($result !== true)
			{
				U::rollback();
				return ['code' => 1, 'msg' => '购失败，请重新提交'];
			}
			
			// 添加明细
			$mxData = mingxi_add(1, 1, $vipPrice, $user['money'],  $user['id']);
			$mingxi = $user -> mingxis() -> save($mxData);
			if(empty($mingxi))
			{
				U::rollback();
				return ['code' => 1, 'msg' => '购失败，请重新提交'];
			}
			
			// 减少可用余额 - 增加消费金额 - 增加消费奖励金额
			$moneyResult = U::where('id', session('userid')) -> dec('money', $vipPrice) -> save();
			$expense_money = U::where('id', session('userid')) -> inc('expense_money', $vipPrice) -> save();
			$award_money = U::where('id', session('userid')) -> inc('award_money', $vipPrice) -> save();
			if(empty($moneyResult) || empty($expense_money) || empty($award_money))
			{
				U::rollback();
				return ['code' => 1, 'msg' => '购失败，请重新提交'];
			}
			
			U::commit();
			
			$vipStr = vip($level, 2);
			return ['code' => 0, 'msg' => '恭喜您成功升级'.$vipStr.'！'];
		}
		
		$where = [
			['status', '=', 1],
			['ms', 'in', '1,2,3'],
			['type', '=', 1],
		];
		
		$list = Kd::where($where) -> order('sort_order asc') -> select();
		$vip = V::find();
		
		$this -> assign('list', $list);
		$this -> assign('vip', $vip);
		return $this -> fetch();
	}
	
	// 用户信息
	function info()
	{
		if(request() -> isAjax())
		{
			$valiResult = $this -> validate(input(), 'User.info');
			if($valiResult !== true)
			{
				return ['code' => 1, 'msg' => $valiResult];
			}
			
			$user = U::find(session('userid'));
			$result = $user -> save(input());
			if($result !== true)
			{
				return ['code' => 1, 'msg' => '保存失败'];
			}
			
			return ['code' => 0, 'msg' => '保存成功'];
		}
		
		return $this -> fetch();
	}
	
	// 修改密码
	function pass()
	{
		if(request() -> isAjax())
		{
			
			$valiResult = $this -> validate(input(), 'User.pass');
			if($valiResult !== true)
			{
				return ['code' => 1, 'msg' => $valiResult];
			}
			
			$user = U::find(session('userid'));
			if(md5(md5(input('passworda/s'))) !== $user['password'])
			{
				return ['code' => 1, 'msg' => '原密码有误'];
			}
			
			$user -> password = input('passworda');
			$result = $user -> save();
			if($result !== true)
			{
				return ['code' => 1, 'msg' => '保存失败'];
			}
			
			return ['code' => 0, 'msg' => '保存成功'];
		}
		
		return $this -> fetch();
	}
	
	// 发货地址
	function address()
	{
		$user = U::find(session('userid'));
		$address = $user -> address;
		$this -> assign('address', $address);
		return $this -> fetch();
	}
	
	// 添加发货地址
	function address_add()
	{
		if(request() -> isPost())
		{
			$data = [
				'addresser' => input('addresser/s'),
				'phone' => input('phone/s'),
				'province' => input('province/s'),
				'city' => input('city/s'),
				'county' => input('county/s'),
				'address' => input('address/s'),
				'postcode' => input('postcode/d'),
			];
			
			
			$valiResult = $this -> validate($data, 'Address');
			if($valiResult !== true)
			{
				return ['code' => 1, 'msg' => $valiResult];
			}
			
			
			$user = U::find(session('userid'));
			$result = $user -> address() -> save($data);
			if(empty($result))
			{
				return ['code' => 1, 'msg' => $result -> getError()];
			}
			
			
			return ['code' => 0, 'msg' => '添加成功'];
		}
		
		return $this -> fetch();
	}
	
	
	// 设置默认地址
	function address_default()
	{
		if(request() -> isPost())
		{
			$default = Ad::where('default', 1) -> find();
			if(! empty($default))
			{
				$default -> default = 0;
				$default -> save();
			}
			
			$id = input('id/d');
			$address = Ad::find($id);
			$address -> default = 1;
			$result = $address -> save();
			if($result !== true)
			{
				return ['code' => 1, 'msg' => $address -> getError()];
			}
			
			return ['code' => 0, 'msg' => '设置成功'];
		}
		
	}
	
	// 删除地址
	function address_del()
	{
		if(request() -> isPost())
		{
			$id = input('id/d');
			$result = Ad::destroy($id);
			if($result !== true)
			{
				return ['code' => 1, 'msg' => $result -> getError()];
			}
			
			return ['code' => 0, 'msg' => '删除成功'];
		}
		
	}
	
	
}
































