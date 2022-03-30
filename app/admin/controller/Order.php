<?php
namespace app\admin\controller;

use app\common\model\Order as O;
use app\common\model\Kd as K;

require '../vendor/autoload.php';
require '../vendor\phpoffice\phpexcel\Classes\PHPExcel\Cell/DataType.php';
require '../vendor\phpoffice\phpexcel\Classes\PHPExcel\IOFactory.php';
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;

class Order extends Base
{
	// 底单列表
	public function index()
	{
		
		$kd_id = input('kd_id/d', 0);
		$status = input('status/d', 0);
		
		$kdidStr = '';
		! empty($kd_id) and $kdidStr .= '&kd_id='.$kd_id;
		
		$statusStr = '';
		! empty($status) and $statusStr .= '&status='.$status;
		
		$where = [['status', '=', 1], ['type', '=', 1]];
		$kd = K::where($where) -> order('sort_order') -> select();
		
		
		$this -> assign('kd_id', $kd_id);
		$this -> assign('status', $status);
		$this -> assign('kdidStr', $kdidStr);
		$this -> assign('statusStr', $statusStr);
		$this -> assign('kd', $kd);
		return $this -> fetch();
	}
	
	// 底单数据
	public function index_data()
	{
		
		$status = input('status/d', 0);
		$kd_id = input('kd_id/d', 0);
		$number = input('number/s');
		$field = input('field/s');
		$sort = input('order/s');
		
		// layui 参数
		$limit = input('limit/d', 50);
		
		$where = [];
		$order = [];
		
		! empty($kd_id) and $where[] = ['a.kd_id', '=', $kd_id];
		! empty($status) and $where[] = ['a.status', '=', $status];
		! empty($number) and $where[] = ['a.number', '=', $number];
		! empty($field) ? $order['a.'.$field] = $sort : $order['a.id'] = 'DESC';
		
		$count = O::alias('a') -> join('user b', 'a.user_id=b.id') -> where($where) -> count();
		$list = O::alias('a') -> join('user b', 'a.user_id=b.id') -> field('a.*, b.username') -> where($where) -> order($order) -> paginate($limit) -> toArray();
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
	
	// 底单信息
	public function view()
	{
		$id = input('id/d');
		$order = O::find($id);
		
		if(request() -> isPost())
		{
			$data = [
				'status' => input('status/d'),
				'content' => input('content/s'),
				'dispose_time' => time(),
			];
			
			$result = $order -> save($data);
			if($result !== true)
			{
				return $this -> error('保存失败');
			}
			
			return $this -> akali('修改成功');
		}
		
		$this -> assign('order', $order);
		return $this -> fetch();
	}
	
	// 导出EXCEL
	public function export()
	{
		$ids = input('ids');
		if(empty($ids))
		{
			return $this -> error('没有选中单号');
		}
		$ids = array_unique($ids);
		
		
		$data = O::where('id', 'in', $ids) -> select();
		
		
		$objPHPExcel = new PHPExcel(); //实例化
		//设置excel的属性
		$objPHPExcel->getProperties()->setCreator("JAMES")
					->setLastModifiedBy("JAMES")
					->setTitle("zltrans")
					->setSubject("Dorder")
					->setDescription("Dorder list")
					->setKeywords("Dorder")
					->setCategory("Test result file");
	
		//设置 在第一个标签中写入数据 设置活动的sheet 是第一个 从0开始
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','快递名称')
					->setCellValue('B1','快递单号')
					->setCellValue('C1','寄件姓名')
					->setCellValue('D1','寄件人地址')
					->setCellValue('E1','寄件人手机')
					->setCellValue('F1','收件姓名')
					->setCellValue('G1','收件人地址')
					->setCellValue('H1','收件人手机')
					->setCellValue('I1','快递重量')
					->setCellValue('J1','快递件数')
					->setCellValue('K1','内件详情')
					->setCellValue('L1','发件日期')
					->setCellValue('M1','平台');
					
		
		

		$o = 2;							
	    foreach($data as $v)
		{
			
			// 快递名称拆分
			$kdlx = mb_substr($v['kdname'], 0, 4, 'utf-8');
			$kdpt = mb_substr($v['kdname'], 5, -1, 'utf-8');
			if(empty($kdpt))
			{
				$kdpt = '淘宝天猫';
			}
			
			
			
			$ftime = date('Y-m-d', $v['ftime']);
			

			$objPHPExcel->getActiveSheet()->setCellValueExplicit("A{$o}","{$kdlx}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式
			
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("B{$o}","{$v['number']}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式
			
			$objPHPExcel->getActiveSheet()->setCellValue("C{$o}","{$v['fname']}");
			
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("D{$o}","{$v['faddress']}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式
			
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("E{$o}","{$v['fphone']}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式
			$objPHPExcel->getActiveSheet()->setCellValue("F{$o}","{$v['sname']}");
			
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("G{$o}","{$v['saddress']}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("H{$o}","{$v['sphone']}",PHPExcel_Cell_DataType::TYPE_STRING);//设置为文本格式
			
			$objPHPExcel->getActiveSheet()->setCellValue("I{$o}","{$v['kg']}kg")->setCellValue("J{$o}","1")->setCellValue("K{$o}","{$v['goods_name']}");
			
			$objPHPExcel->getActiveSheet()->setCellValue("L{$o}","{$ftime}")->setCellValue("M{$o}","{$kdpt}");
			// echo '阿卡丽';
			// dump($objPHPExcel);
			// return;
			$o++;
		}
		
		
		//保存
		$title = date('YmdHis')."-51kongbaoo底单申请";
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header("Pragma: public");
		header("Expires: 0");
		header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");;
		header("Content-Disposition:attachment;filename={$title}.xls");
		header("Content-Transfer-Encoding:binary");
		$objWriter->save('php://output');
		exit;
	}
	
	// 上传底单图片
	function order_image()
	{
		if(request() -> isPost())
		{
			// sleep(1);
			// 获取图片原名称
			$name = $_FILES['file']['name'];
			$name = substr($name, 0, 4);
			
			$where = array();
			$where[] = ['status', '=', 1];
			$where[] = ['number', 'like', '%'.$name];
			
			$order = O::where($where) -> find();
			if(empty($order))
			{
				$data['code'] = 1;
				$data['msg']   = "找不到单号";
				return $data;
			}
			
			$file = request() -> file('file');
			$files = request() -> file();
			
			try {
				validate(['image'=>'filesize:5242880|fileExt:jpg,png,gif']) -> check($files);
				$savename = \think\facade\Filesystem::disk('public') -> putFile( 'order', $file);
				$image = '/static/upload/' . $savename;
			} catch (think\exception\ValidateException $e) {
				return ['code' => 1, 'msg' => $e -> getMessage()];
			}
			
			
			$data['status'] = 2;
			$data['content'] = '<img src="'. $image .'" alt="" />';
			
			
			$result = $order -> save($data);
			if(! $result)
			{
				return ['code' => 1, 'msg' => '更新失败'];
			}
			
			return ['code' => 0, 'msg' => '上传成功', 'name' => $name];
			
		}
		
		return $this -> fetch(); 
	}
	
}
















