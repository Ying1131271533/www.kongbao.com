<?php
namespace app\web\controller;

use app\common\controller\ViewController;
use app\common\model\Article as A;
use app\common\model\Link as L;

class Home extends ViewController
{
    public function index()
    {
		//新闻公告
		$Articlewhere['status'] = 1;
		$Articlewhere['type_id'] = 3;
		$Articledata = A::where($Articlewhere) -> order('create_time DESC')->limit(6)->select();
		
		$ggwhere['status'] = 1;
		$ggwhere['type_id'] = 1;
		$gg = A::where($ggwhere) -> order('create_time DESC') -> limit(7) -> select();
		
		//友情链接
		$link = L::order('weight DESC') -> select();
		
		//假下单显示
		$jname = array('慧','涛','微','维','洁','杰','珊','琪','玲','铃','文','刚','圆','帅','峰','凤','沛','华','强','烨','昇','总','雯','靓','洛','璟','煜','芮','睿','晨','熠','悟','莹','颖','语','烜','瑄','萱','轩','珸','羽','璇','允','芸','沺','苒','阳','煦','珊','灿','耀','烨','诺','玥','悦','跃','峥','知','智','旭','珝','珬','珂','姁','琬','妧','炎','妍','珚','彦','琰','婷','琅','朗','卓','琢','凡','思','宇','郁','璨','琛','璠','琦','锦','琰','玥','琨','玮','璋','璜','珏','琢','珲','璧','宝','玉','芳','姐','露','轩','萌','雅');
		
		$kd = array('龙邦速递(1)单','亚风快递(1)单','天天快递(1)单','全峰快递(1)单','增益速递(1)单','优速快递(1)单','天天快递(1)单','申通快递(1)单','申通快递(1)单');
		
		//$gd = array();
		for($i=1;$i<14;$i++){
			$gd[$i] = array(
				'create_time'=> date('Y-m-d'),
				'name'=> '**'.$jname[rand(1,102)],
				'kd'=>$kd[rand(1,8)],
			);
		}
			
		//print_r($gd);
		
		$this->assign('gd', $gd);
		$this->assign('link',$link);
		//$this->assign('list',$list);
		$this->assign('article',$Articledata);
		$this->assign('gg',$gg);
		
		return $this -> fetch();
    }
	
    
	
}


















