<?php
namespace app\web\controller;

use app\common\model\User as U;
use app\common\model\Tixian as T;
use app\common\model\Mingxi as M;

class Tixian extends Base
{
	// 添加支付宝账号
    public function account()
    {
		if(request() -> isPost())
		{
			$data = [
				'alipay' => input('alipay'),
				'name' => input('name'),
			];

			//验证规则
			$valiResult = $this -> validate($data, 'Account');
			if($valiResult !== true)
			{
				return json(['code' => 1, 'msg' => $valiResult]);
			}
			
			$user = U::find(session('userid'));
			$result = $user -> save($data); 
			if($result !== true)
			{
				return json(['code' => 1, 'msg' => '保存失败']);
			}
			
			return json(['code' => 0]);
		}
		
		return $this -> fetch();
    }
	
	//我要提现
    public function index()
    {
		M::startTrans();
        if (request() -> isPost()) {
            $data = [
                'money' 	=> input('money'),
                'alipay'	=> input('alipay'),
                'name'		=> input('name'),
            ];
			
            //验证规则
            $valiResult = $this -> validate($data, 'Tixian');
            if ($valiResult !== true) {
                return json(['code' => 1, 'msg' => $valiResult]);
            }
			
            $user = U::find(session('userid'));
			//判断提现金额是否大于账号余额
            $rse = $user['money']  - $data['money'];
            if ($user['money'] < $data['money']) {
                return json(['code' => 1, 'msg' => '提现金额不能超过可用金额']);
            }
			
			//取一条最新时间提现未处理的充值记录
			$Twhere['status'] =1;
			$Twhere['user_id']=session('userid');

			$tixian_result = T::where($Twhere) -> order('create_time', 'desc') -> find();
			$settime = date("Y-m-d H:i:s", strtotime("-7 days")); // 一星期前的时间
			//判断上次提现时间是否是一周前
			if ($tixian_result['create_time'] > $settime) {
				return json(['code' => 1, 'msg' => '你有未处理的提现订单，离上次提现一周后方可再次提现']);
			}

			//添加资金明细记录
			$mingxiData = mingxi_add(1, 4, $data['money'], $user['money'], $user['id']);
			$result = $user -> mingxis() -> save($mingxiData);	
			if (empty($result)) {
				M::rollback();
				return json(['code' => 1, 'msg' => '申请失败']);
			}
			
			//提现金额减去余额，增加冻结金额
			$addu = U::find($user['id']);
			$addu-> money 			= $addu['money']-$data['money'];
			$addu-> frost_money     = $addu['frost_money']+$data['money'];
			$result = $addu -> save();

			if (empty($result)) {
				M::rollback();
				return json(['code' => 1, 'msg' => '申请失败']);
			}
			
			//生成提现记录
			$tixian['money']           	= $data['money'];//提现金额
			$tixian['ip']      	      	= get_ip();//提现ip
			$tixian['status']         	= 1;//状态
			$tixian['name']    			= $user['name'];//真实姓名
			$tixian['alipay']      		= $user['alipay'];//支付宝账号
			$tixian['create_time']		= time(); //提现时间
			
			$result = $user -> tixians() -> save($tixian);
			
			if (empty($result)) {
				M::rollback();
				return json(['code' => 1, 'msg' => '申请失败']);
			}
			
			M::commit();
			return json(['code' => 0, 'msg' => '提现申请成功']);
		}
		
		return $this -> fetch();
    }
	
	
    public function record()
    {
		// 查询状态为1的用户数据 并且每页显示10条数据
		$list = T::where('user_id', session('userid')) -> order('create_time desc') -> paginate(18);
		// 获取总记录数
		$count = $list -> total();
		// 获取分页显示
		$page = $list -> render();
		
		// 把分页数据赋值给模板变量list
		$this -> assign('list', $list);
		$this -> assign('count', $count);
		$this -> assign('page', $page);
		
		return $this -> fetch();
    }
	
	
}


















