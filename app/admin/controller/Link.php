<?php
namespace app\admin\controller;

use think\facade\Request;
use think\facade\Db;
use think\Facade;
use think\facade\View;
use app\common\model\Link as L;

class Link extends Base
{
	//友情链接展示页面
	public function index(){
		$number = input('number/d', 0);
		
		$this -> assign('number', $number);
		return $this -> fetch();
	}
	//友情链接展示数据
	public function index_data(){
		$number = input('number/s');
		$field = input('field/s');
		$sort = input('title/s');
		$limit = input('limit/d', 20);
		
		$where = [];
		$title = [];
		
		! empty($number) and $where[] = ['title', 'like', '%'.$number.'%'];

		$count = L:: where($where) -> count();
		$list = L:: where($where) -> order('weight DESC') -> paginate($limit) -> toArray();
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


	//友情链接添加页面
	public function link_add(){
		return $this -> fetch();
	}
	//友情链接添加
	public function link_adds(){
		$title = Request::param('title');
		$url   = Request::param('url');
		$weight= Request::param('weight');
			if(empty($title) || empty($url) || empty($weight)){
				$data = $this->error('数据不能为空');
			}else{
				$Link           = new L;
				$Link->title    = $title;
				$Link->url      = $url;
				$Link->weight   = $weight;
				$Link->create_time   = time();
				$result = $Link->save();
			if($result){
				$data = $this->success('添加成功','/index.php/link/index');
			}else{
				$data = $this->error('添加失败','/index.php/link/index');
			}
		}
	}


	//友情链接修改页面
	public function link_edit(){
		$id = input('id/d');
		$Link = L::find($id);
			if (request() -> isPost()) {
				$id 	= input('id/d');
				$title 	= input('title/d');
				$weight = input('weight/d');
				$url 	= input('url/d');
				$failure = input('failure');
				if(empty($title) || empty($url) || empty($weight)){
					$data = $this->error('数据不能为空');
				}else{
				//修改
				$Link = L::find($id);
				$Link -> title = $title;
				$Link -> weight = $weight;
				$Link -> url = $url;
				$Link -> title = $title;
				$Link -> check_time = time();
				$result = $Link -> save();
				if ($result) {
					return $this -> success('修改成功');
				}else{
					return $this -> error('网络异常');

				}
			}
		
		}
		$this -> assign('list', $Link);
		return $this -> fetch();
	}
	//友情链接修改
	public function link_update(){
		$title    = Request::param('title');
		$url      = Request::param('url');
		$weight   = Request::param('weight');
		$id       = Request::param('id');
		$time     = time();
		$result   =	Links::update(['title' => "$title", 'id' => "$id" ,'url'=>"$url" ,'weight'=>"$weight" ,'create_time'=>"$time"]);
			if($result){
				$data = $this->success('修改成功','/index.php/link/index');
			}else{
				$data = $this->error('网络异常','/index.php/link/index');
			}
	}

	//友情链接删除
	public function link_del(){
		$where['id'] =Request::param('id');
		$res =Db::table('link')->where($where)->delete();
			if($res){
				$data = $this->success('删除成功','/index.php/link/index');
			}else{
				$data = $this->error('网络异常','/index.php/link/index');
		}
	}
}
