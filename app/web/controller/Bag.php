<?php
namespace app\web\controller;

use app\common\model\User as U;
use app\common\model\Kd as K;
use app\common\model\Address as Ad;
use app\common\model\Mingxi as M;
use app\common\model\Bag as B;


require '../vendor/autoload.php';
require '../vendor/phpoffice/PHPExcel/Classes/PHPExcel/Cell/DataType.php';
require '../vendor/phpoffice/PHPExcel/Classes/PHPExcel/IOFactory.php';
require '../vendor/phpoffice/PHPExcel/Classes/PHPExcel/Cell.php';
use PHPExcel;
use PHPExcel_Cell_DataType;
use PHPExcel_IOFactory;
use PHPExcel_Cell;


class Bag extends Base
{
	function index()
	{
		$number = input('number/s');
		$sname = input('sname/s');
		$saddress = input('saddress/s');
		
		$user_id = session('userid');
		$limit = input('limit/d', 20);
		
		// dump(input());return;
		
		$where = [];
		$order = [];
		
		
		
		! empty($number) and $where[] = ['a.number', '=', $number];
		! empty($status) and $where[] = ['a.sname', '=', $sname];
		! empty($saddress) and $where[] = ['a.saddress', 'like', '%'.$saddress.'%'];
		! empty($user_id) and $where[] = ['a.user_id', '=', $user_id];
		! empty($field) ? $order['a.' . $field] = $sort : $order['a.id'] = 'DESC';
		
		
		
		$list = B::alias('a')
				-> join('kd b', 'a.kd_id=b.id')
				-> join('address d', 'a.address_id=d.id')
				-> field('d.*, b.name as kd_name, a.*')
				-> where($where)
				-> order($order)
				-> paginate($limit);
		$page = $list-> render();
		// dump($list);
		$this -> assign('limit', $limit);
		$this -> assign('list', $list);
		$this -> assign('page', $page);
		return $this -> fetch();
	}
	
	// 单个
    public function buy()
    {
		if(request() -> isAjax())
		{
			$kd_id = input('kd_id/d');
			$user = U::find(session('userid'));
			$kd = K::field('cost_price,'.'level'.$user['level'].',apitype') -> where('id', $kd_id) -> find();
			// dump($kd);return;
			
			
			if(empty($kd_id))
			{
				return ['code' => 1, 'msg' => '请选择快递公司'];
			}
			
			
			
			// 地址拼装
			$address = input('saddress/s');
			$address = explode(" ", $address);
			$length = count($address);
			$saddress = '';
			for($i = 3; $i < $length; $i++)
			{
				$saddress .= ' '.$address[$i];
			}
			
			// 接口订单号
			$onb = time() . rand(10000, 99999);
			
			$data = [
				'kd_id' => $kd_id,
				'address_id' => input('address_id/d'),
				'sname' => input('sname/s'),
				'sprovince' => $address[0],
				'scity' => $address[1],
				'scounty' => $address[2],
				'saddress' => $saddress,
				'sphone' => input('sphone/s'),
				'goods_name' => input('goods_name/s'),
				'kg' => input('kg/f'),
				'time' => time(),
				'price' => $kd['level'.$user['level']],
				'onb' => $onb,
			];
			
			
			$faddress = Ad::find($data['address_id']);
			
			
			// 数组json
			$dataJson = [
				"fprovince"		=> 	$faddress['province'],
				"fcity"			=> 	$faddress['city'],
				"fcounty"		=> 	$faddress['county'],
				"faddress"		=> 	$faddress['address'],
				"fname"			=> 	$faddress['addresser'],
				"fphone"		=> 	$faddress['phone'],
				"sprovince"		=> 	$data['sprovince'],
				"scity"			=> 	$data['scity'],
				"scounty"		=> 	$data['scounty'],
				"saddress"		=> 	$data['saddress'],
				"sname"			=> 	$data['sname'],
				"sphone"		=> 	$data['sphone'],
				"goods_name"	=> 	$data['goods_name'],
				"kg"			=> 	$data['kg'],
				'onb' 			=>	$data['onb'],
			];
			
			$dataJsonStr = base64_encode(json_encode($dataJson));
			
			
			// 接口请求数据
			$array = [
				'key' => 'c4ca4238a0b923820dcc509a6f75849b',
				'action'  => 'number',
				'apitype' => $kd['apitype'],
				'count' => 1,
				'msg' => $dataJsonStr,
			];
			
			// dump($dataJsonStr);return;
			
			$url = 'http://api.daili.com/number/index.html?key='.$array['key']
			.'&action='.$array['action']
			.'&apitype='.$array['apitype']
			.'&count='.$array['count']
			.'&msg='.$array['msg'];
			$number = jm_number($url, $array);
			// dump($number);return;
			if($number['code'] != 0)
			{
				return $number;
			}
			
			$data['number'] = $number['data']['number'];
			$data['cost_price'] = $number['data']['cost_price'];
			
			$valiResult = $this -> validate($data, 'Bag');
			if($valiResult !== true)
			{
				return ['code' => 1, 'msg' => $valiResult];
			}
			
			
			// dump($valiResult);return;
			
			// 金额是否足够
			if($user['money'] < $data['price'])
			{
				return ['code' => 1, 'msg' => '余额不足，请充值'];
			}
			
			
			// 开启事务
			U::startTrans();
			
			// 减少可用余额 - 增加消费金额 - 增加消费奖励金额
			$moneyResult = U::where('id', session('userid')) -> dec('money', $data['price']) -> save();
			$expense_money = U::where('id', session('userid')) -> inc('expense_money', $data['price']) -> save();
			$award_money = U::where('id', session('userid')) -> inc('award_money', $data['price']) -> save();
			if(empty($moneyResult) || empty($expense_money) || empty($award_money))
			{
				U::rollback();
				return ['code' => 1, 'msg' => '购买超时，请重新提交'];
			}
			
			
			// 空包保存
			$bag = $user -> bags() -> save($data);
			if(empty($bag))
			{
				U::rollback();
				return ['code' => 1, 'msg' => '购买超时，请重新提交'];
			}
			
			
			// 添加明细
			$mxData = mingxi_add(1, 1, $data['price'], $user['money'],  $user['id']);
			$mingxi = $user -> mingxis() -> save($mxData);
			if(empty($mingxi))
			{
				U::rollback();
				return ['code' => 1, 'msg' => '购买超时，请重新提交'];
			}
			
			// dump($mingxi);
			// return;
			
			U::commit();
			return ['code' => 0, 'msg' => '购买成功，请到对应的淘宝、京东、拼多多后台点发货，否则物流是不会更新'];
		}
		
		$where = [
			['status', '=', 1],
			['ms', 'in', '1,2,3'],
			['type', '=', 1],
		];
		
		$kd = K::where($where) -> order('sort_order asc') -> select();
		$user = U::find(session('userid'));
		$address = $user -> address;
		
		// dump($where);
		// dump($kd);
		$this -> assign('kd', $kd);
		$this -> assign('address', $address);
		return $this -> fetch();
    }
	
	// 批量
    public function buy_pl()
    {
		if(request() -> isAjax())
		{
			$kd_id = input('kd_id/d');
			$address_id = input('address_id/d');
			$content = input('content/s');
			$goods_name = input('goods_name/s');
			$kg = input('kg/f');
			
			
			
			$user = U::find(session('userid'));
			$kd = K::field('cost_price,'.'level'.$user['level'].',apitype') -> where('id', $kd_id) -> find();
			
			$content = str_replace('，', ',', $content);//替换逗号为统一逗号
			$content = str_replace(', ', ',', $content);//逗号后面有空格也替换掉空格
			$content = str_replace(' ,', ',', $content);//逗号前面有空格也替换掉空格
			$content = str_replace('86-', '', $content);//去掉86-
			$content = explode("\n", $content);//处理换行
			$content_arr = array_filter($content); //如果光标在第二行，将出现空白数组，使用此函数删除空白数组
			$content_count = count($content_arr);//换行总数
			
			// dump($content);return;
			
			if($content_count > 200)
			{
				return ['status' => 0, 'msg' => '最多可一次性下单200条，请勿超过下单数量。'];
			}
			
			$i = 1;
			foreach($content_arr as $value)
			{
				$result = ! preg_match("/^([\x{4e00}-\x{9fa5}\A-Za-z0-9]{2,18}\,){1}([0-9_-]{5,16}\,){1}([\x{4e00}-\x{9fa5}]{2,7}[\ ][\x{4e00}-\x{9fa5}]{2,12}[\ ][\x{4e00}-\x{9fa5}]{2,12}[\ ][\x{4e00}-\x{9fa5}A-Za-z0-9\(\)\（\）\{\}\-\#\:\：\[\]\ ]+\,){1}$/u", $value);
				if($result === false)
				{
					$data['status'] = 0;
					$data['msg']   = "第{$i}个收货信息有错误,
					请仔细检查是否有不合规的信息格式。";
					return $data;
				}
				$i++;
			}
			
			// 下单总价格
			$price = $kd['level'.$user['level']] * $content_count;
			// dump($price);return;
			// 金额是否足够
			if($user['money'] < $price)
			{
				return ['status' => 1, 'msg' => '余额不足，请充值'];
			}
			
			
			// 商家地址
			$faddress = Ad::find($address_id);
			
			// 接口订单号
			$onb = time() . rand(10000, 99999);
			
			
			$bagData = [];
			
			$k = 1;
			$all = $content_count;
			foreach($content_arr as $key => $value)
			{
				
				// 收货人信息
				$arr = explode(",", $value); // 分割收货人信息
				
				// 地址分割
				$address = explode(" ",$arr[2]);
				$length = count($address);
				$saddress = '';
				for($i = 3; $i < $length; $i++)
				{
					$saddress .= ' '.$address[$i];
				}
				
				$data = [
					'kd_id' => $kd_id,
					'address_id' => input('address_id/d'),
					'sname' => $arr[0],
					'sprovince' => $address[0],
					'scity' => $address[1],
					'scounty' => $address[2],
					'saddress' => $saddress,
					'sphone' => $arr[1],
					// 'spostcode' => input('spostcode/d'), // 邮编
					'goods_name' => input('goods_name/s'),
					'kg' => input('kg/f'),
					'time' => time(),
					'onb' => $onb,
					'price' => $kd['level'.$user['level']],
				];
				
				
				$valiResult = $this -> validate($data, 'Bag');
				if($valiResult !== true)
				{
					return ['status' => 0, 'msg' => "第{$k}个收货信息".$valiResult];
				}
				
				// dump($valiResult);return;
				
				
				// 数组json
				$dataJson = [
					"fprovince"		=> 	$faddress['province'],
					"fcity"			=> 	$faddress['city'],
					"fcounty"		=> 	$faddress['county'],
					"faddress"		=> 	$faddress['address'],
					"fname"			=> 	$faddress['addresser'],
					"fphone"		=> 	$faddress['phone'],
					"sprovince"		=> 	$data['sprovince'],
					"scity"			=> 	$data['scity'],
					"scounty"		=> 	$data['scounty'],
					"saddress"		=> 	$data['saddress'],
					"sname"			=> 	$data['sname'],
					"sphone"		=> 	$data['sphone'],
					"goods_name"	=> 	$data['goods_name'],
					"kg"			=> 	$data['kg'],
					"onb"			=> 	$data['onb'],
				];
				
				$dataJsonStr = base64_encode(json_encode($dataJson));
				
				
				// 接口请求数据
				$array = [
					'key' => 'c4ca4238a0b923820dcc509a6f75849b',
					'action'  => 'number',
					'apitype' => $kd['apitype'],
					'count' => 0,
					'all' => $all,
					'msg' => $dataJsonStr,
				];
				
				if($k === $content_count)
				{
					$array['count'] = $content_count;
				}
				
				// dump($dataJsonStr);
				// dump(json_encode($dataJson, true));
				// dump($dataJson);
				// return;
				
				
				$url = 'http://api.daili.com/number/index.html?key='.$array['key']
				.'&action='.$array['action']
				.'&apitype='.$array['apitype']
				.'&count='.$array['count']
				.'&all='.$all
				.'&msg='.$array['msg'];
				$number = jm_number($url, $array);
				// dump($url);
				// dump($number);
				// return;
				if($number['code'] != 0)
				{
					if($array['count'] != 0)
					{
						// 接口请求数据
						$errorArray = [
							'key' => 'c4ca4238a0b923820dcc509a6f75849b',
							'action'  => 'del',
							'onb' => $onb,
						];
						$errorUrl = 'http://api.daili.com/number/index.html?key='.$array['key'].'&action=del&onb='.$onb;
						// http://api.daili.com/number/index.html?key=c4ca4238a0b923820dcc509a6f75849b&action=del&onb=156810887945198
						// 退款给商家
						$del = jm_number($errorUrl, $errorArray);
					}
					
					return $number;
				}
				
				
				$data['number'] = $number['data']['number'];
				$data['cost_price'] = $number['data']['cost_price'];
				
				
				
				$bagData[] = $data;
				
				$all--;
				$k++;
			}
			
			
			// 开启事务
			U::startTrans();
			// 空包保存
			$bag = $user -> bags() -> saveAll($bagData);
			// dump($bag);return;
			if(empty($bag))
			{
				U::rollback();
				return ['status' => 0, 'msg' => '购买超时，请重新提交'];
			}
			
			
			// 添加明细
			$mxData = mingxi_add(1, 1, $price, $user['money'],  $user['id']);
			$mingxi = $user -> mingxis() -> save($mxData);
			if(empty($mingxi))
			{
				U::rollback();
				return ['status' => 0, 'msg' => '购买超时，请重新提交'];
			}
			
			// 减少可用余额 - 增加消费金额 - 增加消费奖励金额
			$moneyResult = U::where('id', session('userid')) -> dec('money', $price) -> save();
			$expense_money = U::where('id', session('userid')) -> inc('expense_money', $price) -> save();
			$award_money = U::where('id', session('userid')) -> inc('award_money', $price) -> save();
			if(empty($moneyResult) || empty($expense_money) || empty($award_money))
			{
				U::rollback();
				return ['status' => 0, 'msg' => '购买超时，请重新提交'];
			}
			
			// dump($mingxi);
			// return;
			
			U::commit();
			
			return ['status' => 1, 'msg' => "购买成功{$content_count}单,共消费{$price}元，请到对应的淘宝、京东、拼多多后台点发货，否则物流不会更新"];
		}
		
		$where = [
			['status', '=', 1],
			['ms', 'in', '1,2,3'],
			['type', '=', 1],
		];
		
		$kd = K::where($where) -> order('sort_order asc') -> select();
		$user = U::find(session('userid'));
		$address = $user -> address;
		
		// dump($where);
		// dump($kd);
		$this -> assign('kd', $kd);
		$this -> assign('address', $address);
		return $this -> fetch();
    }
	
	// 导入excel文档
	function excel()
	{
		if(request() -> isPost())
		{
			if(! session('userid'))
			{
				$data['status'] = 2;
				$data['data']   = '请重新登录帐号';
				return $data;
			}
			
			$filedata = $this -> upload_excel();
			if($filedata['code'] == 1)
			{
				$data['status'] = 0;
				$data['data']   = $filedata['msg'];
				return $data;
			}
			

			$inputFileType = 'Excel2007'; //这个是计xlsx的
			$inputFileName = $filedata['excel']; //文件
			
			$objReader = PHPExcel_IOFactory::createReader($inputFileType);
			$objPHPExcel = $objReader->load($inputFileName);
			
			$objWorksheet = $objPHPExcel->getSheet(0);
			
			$highestRow = $objWorksheet->getHighestRow(); // 取得总行数 
			
			if($highestRow < 1){
				$data['status'] = 0;
				$data['data']   = 'Excel格式有错误，请下载模版查看';
				return $data;
			}
			
			$highestColumn = $objWorksheet->getHighestColumn(); // 取得总列数
			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
			$headtitle = array();
			$info = '';
			for ($row = 2; $row <= $highestRow; $row++){
				$strs=array();
				//注意highestColumnIndex的列数索引从0开始
				for ($col = 0;$col < $highestColumnIndex;$col++)
				{
					$strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
				}
				$name = str_replace(" ","",$strs[0]);
				$phone = str_replace(" ","",$strs[1]);
				$sheng = str_replace(" ","",$strs[2]);
				$shi = str_replace(" ","",$strs[3]);
				$qu = str_replace(" ","",$strs[4]);
				$address = str_replace(" ","",$strs[5]);
				// $zip = str_replace(" ","",$strs[6]);
				//$info[$row] = "$strs[0],$strs[1],$strs[2] $strs[3] $strs[4] $strs[5],$strs[6]";
				// $info .= "$name,$phone,$sheng $shi $qu $address,$zip\n";
				$info .= "$name,$phone,$sheng $shi $qu $address\n";
			}
			
			//替换空白信息行
			$info = str_replace(",,   ,\n","",$info);
			
			$data['status'] = 1;
			$data['data']   = rtrim($info, "\n");
			
			return json($data);
		}
	}
	
	// 保存上传的excel文件
	function upload_excel()
	{
		$file = request() -> file('file');
		try {
			// validate(['image'=>'filesize:30000|fileExt:xls,xlsx'])  -> check($file);
			$savename = \think\facade\Filesystem::disk('public') -> putFile( 'excel', $file);
			$data = ['code' => 0, 'msg' => '上传成功', 'excel' => './static/upload/' . $savename];
		} catch (think\exception\ValidateException $e) {
			$data = ['code' => 1, 'msg' => $file -> getError()];
		}
		
		return $data;
	}
	
	// 获取快递信息
	function buy_kd()
	{
		$id = input('id/d');
		$kd = K::find($id);
		return $kd;
	}
	
	//导出单号
	public function bag_export()
	{
		$id = input('subBox/a');
		$id = implode($id, ',');
		
		
		$where = [];
		$order = [];
		
		
		$where[] = ['a.id', 'in', $id];
		$where[] = ['a.user_id', '=', session('userid')];
		! empty($field) ? $order['a.' . $field] = $sort : $order['a.id'] = 'DESC';
		
		
		$data = B::alias('a')
				-> join('kd b', 'a.kd_id=b.id')
				-> join('address d', 'a.address_id=d.id')
				-> field('a.*,b.name as kd_name,d.*')
				-> where($where)
				-> order($order)
				-> select();
		
		
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
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1','序号')
					->setCellValue('B1','收件人')
					->setCellValue('C1','收货地址')
					->setCellValue('D1','发货人')
					->setCellValue('E1','发货地址')
					->setCellValue('F1','快递名称')
					->setCellValue('G1','快递单号')
					->setCellValue('H1','下单时间');
		
		$i=1;
		$o=2;							
	    foreach($data as $v)
		{
			// $dates = date('Y-m-d H:i:s', $v['time']);
			
			$objPHPExcel->getActiveSheet()->setCellValue("A{$o}","{$i}");
			$objPHPExcel->getActiveSheet()->setCellValue("B{$o}","{$v['sname']}");//收件人
			$objPHPExcel->getActiveSheet()->setCellValue("C{$o}","{$v['sprovince']} {$v['scity']} {$v['scounty']} {$v['saddress']}");//收件地址
			
			$objPHPExcel->getActiveSheet()->setCellValue("D{$o}","{$v['addresser']}");//发货人
			$objPHPExcel->getActiveSheet()->setCellValue("E{$o}","{$v['province']} {$v['city']} {$v['county']} {$v['address']}");//发货地址
			
			$objPHPExcel->getActiveSheet()->setCellValue("F{$o}","{$v['kd_name']}");//快递名称
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("G{$o}","{$v['number']}",PHPExcel_Cell_DataType::TYPE_STRING); //设置为文本格式 快递单号
			$objPHPExcel->getActiveSheet()->setCellValueExplicit("H{$o}","{$v['time']}"); //设置为文本格式 快递单号

			$i++;$o++;
		}
		
		
		
		//保存
		$title = "51kongbaoo-".date('YmdHis');
		
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
		exit;
	}
	
	
	
}
































