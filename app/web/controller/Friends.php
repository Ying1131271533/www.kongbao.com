<?php
namespace app\web\controller;

use app\common\model\User as U;
use app\common\model\Reward as R;


class Friends extends Base
{   
    //我的好友
    public function index(){
    $list = U::where('recommend_id', session('userid')) -> order('create_time desc')->field(['username','recommend_id','create_time','level','expense_money','login_counts'])->select();
    $this -> assign('list',$list);
		return $this -> fetch();
    }

    //邀请好友链接
    public function invitation(){
      $id = session('userid');
      $url = "http://www.tp6.com/index.php/register/index/uid/";
      $urls  = $url.$id;
      $this -> assign('url', $urls);
      $this -> assign('id',$id);
      return $this-> fetch();
    }

    //奖励明细
    public function reward(){

    $list = R::alias('a') 
    -> join('user b','b.id=a.user_id') 
    -> field('a.*,b.username,b.money') 
    -> where('xuid', session('userid')) 
    -> order('create_time DESC') 
    -> select() 
    -> toArray();
			$this -> assign('list', $list);
      
		return $this -> fetch();
      
    }
	
    
	
}


















