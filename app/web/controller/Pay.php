<?php
namespace app\web\controller;

use app\common\model\User as U;
use app\common\model\Pay as P;

class Pay extends Base
{
    public function index()
    {
		if(request() -> isPost())
		{
			$data = [
			  'order' => input('number/s'),
			  'money' => input('money/f'),
			  'ip' => get_ip(),
			  'create_time' => time(),
			];
			
			//验证规则
			$valiResult = $this -> validate($data, 'Pay');
			if($valiResult !== true)
			{
				return json(['code' => 1, 'msg' => $valiResult]);
			}

			$id = session('userid');
			$user = U::find($id);
			
			$result = $user -> pays() -> save($data);
			if (empty($result))
			{
				return json(['code' => 1, 'msg' => '提交失败，请刷新页面重新提交']);
			}
			
			return json(['code' => 0, 'msg' => '你的提交已成功待系统审核确认到账']);
		}
		
		return $this -> fetch();
    }
	
    public function record()
    {
			// 查询状态为1的用户数据 并且每页显示10条数据
			$list = P::where('user_id', session('userid')) -> order('create_time desc') -> paginate(18);
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


















