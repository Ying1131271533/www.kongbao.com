<?php
namespace app\admin\controller;

use think\facade\Request;
use think\facade\Db;
use think\Facade;
use think\facade\View;
use app\common\model\Express_order as Express_orders;
class ExpressOrder extends Base
{
	//快递订单首页
	public function index(){
		echo "这里是快递订单页面";
	} 


	
}
