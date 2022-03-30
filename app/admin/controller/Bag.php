<?php
namespace app\admin\controller;

use app\common\model\User as U;
use app\common\model\Bag as B;
use app\common\model\Mingxi as M;
use app\common\model\Kd as K;

require '../vendor/autoload.php';
require '../vendor\phpoffice\phpexcel\Classes\PHPExcel\Cell/DataType.php';
require '../vendor\phpoffice\phpexcel\Classes\PHPExcel\IOFactory.php';
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;


class Bag extends Base
{
	// 空包页面
	public function index()
	{
		$id = input('id/d');
		$kd_id = input('kd_id/d', 0);
		$user_id = input('user_id/d', 0);
		$number = input('number/s');
		$status = input('status/d', 0);
		
		// dump(input());return;
		
		$kdidStr = '';
		! empty($kd_id) and $kdidStr .= '&kd_id='.$kd_id;
		
		$statusStr = '';
		! empty($status) and $statusStr .= '&status='.$status;
		
		$where = [['status', '=', 1], ['type', '=', 1]];
		$kd = K::where($where) -> order('sort_order') -> select();
		
		// dump($kd);return;
		
		$this -> assign('id', $id);
		$this -> assign('kd_id', $kd_id);
		$this -> assign('user_id', $user_id);
		$this -> assign('number', $number);
		$this -> assign('status', $status);
		$this -> assign('kd', $kd);
		
		$this->assign('kdidStr', $kdidStr);
		$this->assign('statusStr', $statusStr);
		
		return $this -> fetch();
	}
	
	// 空包数据
	function index_data()
	{
		$id = input('id/d');
		$kd_id = input('kd_id/d');
		$user_id = input('user_id/d');
		$number = input('number/s');
		$status = input('status/d', 0);
		
		
		$field = input('field/s');
		$sort = input('order/s');
		$limit = input('limit/d', 20);
		
		// dump(input());return;
		
		$where = [];
		$order = [];
		
		
		
		! empty($id) and $where[] = ['a.id', '=', $id];
		! empty($kd_id) and $where[] = ['a.kd_id', '=', $kd_id];
		! empty($user_id) and $where[] = ['a.user_id', '=', $user_id];
		! empty($number) and $where[] = ['a.number', '=', $number];
		! empty($status) and $where[] = ['a.status', '=', $status];
		! empty($field) ? $order['a.' . $field] = $sort : $order['a.id'] = 'DESC';
		
		
		$count = B::alias('a')
				-> join('kd b', 'a.kd_id=b.id')
				-> join('user c', 'a.user_id=c.id')
				-> join('address d', 'a.address_id=d.id')
				-> where($where)
				-> count();
			
		$list = B::alias('a')
				-> join('kd b', 'a.kd_id=b.id')
				-> join('user c', 'a.user_id=c.id')
				-> join('address d', 'a.address_id=d.id')
				-> field('d.*, b.name as kd_name, c.username, a.*')
				-> where($where)
				-> order($order)
				-> paginate($limit)
				-> toArray();
		// dump($list);return;
		
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
	
	function edit()
	{
		$id = input('id/d');
		$bag = B::find($id);
		if(request() -> isPost())
		{
			$data = input();
			
			$valiResult = $this -> validate($data, 'Bag.edit');
			if($valiResult !== true)
			{
				return $this -> error($valiResult);
			}
			
			$result = $bag -> save($data);
			if(empty($result))
			{
				return $this -> error('保存失败');
			}
			
			return $this -> success('保存成功');
		}
		
		$this -> assign('bag', $bag);
		return $this -> fetch();
	}
	
	// 导出单号
	function export()
	{
		if(request() -> isPost())
		{
			$ids = input('ids/a');
			if(empty($ids))
			{
				return $this -> error('没有选中单号');
			}
			$ids = array_unique($ids);
			
			$kd_id = input('kd_id/a');
			$kd_id_conut =  count(array_unique($kd_id));
			if($kd_id_conut !== 1)
			{
				return $this -> error('请选择一个快递公司');
			}
			
			
			$where = [['a.id', 'in', $ids], ['a.kd_id', '=', $kd_id[0]]];
			$data = B::alias('a')
					-> join('address d', 'a.address_id=d.id')
					-> where($where)
					-> select();
			
			
			// dump($data);return;
			
			
			$objPHPExcel = new PHPExcel;
			$dataType = new PHPExcel_Cell_DataType;
			
			//设置excel的属性
			$objPHPExcel->getProperties()
						->setCreator("JAMES")
						->setLastModifiedBy("JAMES")
						->setTitle("zltrans")
						->setSubject("Dorder")
						->setDescription("Dorder list")
						->setKeywords("Dorder")
						->setCategory("Test result file");
			
			
			
			//设置 在第一个标签中写入数据 设置活动的sheet 是第一个 从0开始
			$objPHPExcel->setActiveSheetIndex(0)
				-> setCellValue('A1','序号')
				-> setCellValue('B1','快递单号')
				-> setCellValue('C1','发货省份')
				-> setCellValue('D1','发货城市')
				-> setCellValue('E1','发货区/县')
				-> setCellValue('F1','收货省')
				-> setCellValue('G1','收货市')
				-> setCellValue('H1','收货区')
				-> setCellValue('I1','收货人姓名')
				-> setCellValue('J1','收货详细地址')
				-> setCellValue('K1','重量');
			
			
			$i=1;
			$o=2;							
			foreach($data as $v)
			{
				// 抽取详细地址
				// $detailed_arr = explode(" ", $v['saddress']);
				// $detailed_arr = array_filter($detailed_arr);
				// dump($detailed_arr);return;
				
				$objPHPExcel->getActiveSheet()->setCellValue("A{$o}","{$i}");
				$objPHPExcel->getActiveSheet()->setCellValueExplicit("B{$o}","{$v['number']}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式
				$objPHPExcel->getActiveSheet()
				->setCellValue("C{$o}", "{$v['province']}")
				->setCellValue("D{$o}", "{$v['city']}")
				->setCellValue("E{$o}", "{$v['county']}")
				->setCellValue("F{$o}", "{$v['sprovince']}")
				->setCellValue("G{$o}", "{$v['scity']}")
				->setCellValue("H{$o}", "{$v['scounty']}")
				->setCellValue("I{$o}", "{$v['sname']}")
				->setCellValue("J{$o}", "{$v['saddress']}");
				// ->setCellValue("J{$o}", "{$detailed_arr[3]}");
				$objPHPExcel->getActiveSheet()->setCellValueExplicit("K{$o}", "{$v['kg']}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式  ->setCellValue("K{$o}","{$v[kg]}");
				
				$i++;
				$o++;
			}
			
			
			//保存
			$kd = K::field('name,cost_price') -> where('id', $kd_id[0]) -> find();
			$kdmoney = $kd['cost_price'] * ($i-1);
			
			$title = $kd['name']."-".($i-1)."(".$kdmoney.")-".date('YmdHis');
			
			
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			header('Pragma:public');
			header('Expires:0');
			header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
			header('Content-Type:application/force-download');
			header('Content-Type:application/vnd.ms-excel');
			header('Content-Type:application/octet-stream');
			header('Content-Type:application/download');
			header("Content-Disposition:attachment;filename={$title}.xls" );
			header('Content-Transfer-Encoding:binary');
			$objWriter->save ('php://output');
			
			
			// 修改为已经导出过的状态
			B::where('id', 'in', $ids) -> save(['status' => 1]);
			
			exit;
		}
	}
	
	// 退单号
	function tui()
	{
		$id = input('id/d');
		$user_id = input('user_id/d');
		$number = input('number/s');
		
		
		// 接口退单
		$array = [
			'key' => 'c4ca4238a0b923820dcc509a6f75849b',
			'action'  => 'tui',
			'number' => $number,
			// 'msg' => $dataJsonStr,
		];
		
		// 数组json
		// $dataJson = [
			// "fprovince" => $faddress['province'],
		// ];
		// $dataJsonStr = encrypt(json_encode($dataJson), 'E', 'akali');
		// dump($dataJsonStr);return;
		
		
		$url = 'http://api.daili.com/number/index.html?key='.$array['key']
		.'&action='.$array['action']
		.'&number='.$array['number'];
		$number = jm_number($url, $array);
		if($number['code'] != 0)
		{
			return $this -> error('发生故障，请刷新页面');
		}
		
		// 开启事务
		B::startTrans();
		
		$bag = B::find($id);
		$bag -> status = 2;
		$result = $bag -> save();
		if($result !== true)
		{
			B::rollback();
			return $this -> error('退单失败');
		}
		
		// 添加资金明细
		$user = U::find($user_id);
		$zmoney = $user['money'];
		
		// 增加金额
		$money1 = U::where('id', $user_id) -> inc('money', $bag['price']) -> save();
		$money2 = U::where('id', $user_id) -> dec('expense_money',  $bag['price']) -> save(); //减少消费金额		
		$money3 = U::where('id', $user_id) -> dec('award_money',  $bag['price']) -> save(); //减少奖励消费金额	
		
		$data = mingxi_data(2, 10, $bag['price'], $zmoney);
		// dump($data);return;
		$mxResult = $user -> mingxis() -> save($data);
		if($result !== true)
		{
			B::rollback();
			return $this -> error($mxResult);
		}
		
		B::commit();
		return $this -> success('退单成功');
	}

	// 批量退单号
	public function tuis()
	{
		$ids = input('ids/a');
		if(empty($ids))
		{
			return $this -> error('没有选中单号');
		}
		$ids = array_unique($ids);
		
		// dump(input());return;
		
		$uids = input('uids');
		$uids_conut =  count(array_unique($uids));
		if($uids_conut !== 1)
		{
			return $this -> error('单号组中不能存在不同的用户');
		}
		
		$uid = $uids[0];
		
		if(request() -> isPost())
		{
			$where = [];
			$where[] = array('id', 'in', $ids);
			
			$Bagdata = B::where($where) -> select();
			
			foreach($Bagdata as $value)
			{
				if($value['status'] == 3)
				{
					return $this -> error('单号中存在退单类型的单号');
				}
			}
			
			
			// 开启事务
			B::startTrans();
			
			
			$result = B::where($where) -> save(['status' => '3']); // 修改状态为退单
			if(empty($result))
			{
				B::rollback();
				return $this -> error('操作失败');
			}
			
			$money = 0;
			foreach($Bagdata as $value)
			{
				$money += $value['price'];
			}
			
			$money = sprintf("%.2f",substr(sprintf("%.3f", $money), 0, -2)); 
			
			$user = U::find($uid);
			$zmoney = $user['money'];
			// dump($usemoney);
			// return;
			
			$money1 = U::where('id', $uid) -> inc('money',  $money) -> save(); //增加可用金额
			$money2 = U::where('id', $uid) -> dec('expense_money',  $money) -> save(); //减少消费金额		
			$money3 = U::where('id', $uid) -> dec('award_money',  $money) -> save(); //减少奖励消费金额		
			if(empty($money1 || $money2 || $money3))
			{
				B::rollback();
				return $this -> error('操作失败');
			}
			
			//添加明细
			$data = mingxi_data(2, 10, $money, $user['money']);
			$mxResult = $user -> mingxis() -> save($data);
			if(empty($mxResult))
			{
				B::rollback();
				return $this -> error('操作失败');
			}
			
			B::commit();
			return $this -> success('退单成功');
		}
	}
	
	
	
}

























