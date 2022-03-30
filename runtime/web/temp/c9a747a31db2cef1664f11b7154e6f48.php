<?php /*a:6:{s:47:"D:\Web\www.tp6.com\app\web\view\user\index.html";i:1562034984;s:52:"D:\Web\www.tp6.com\app\web\view\layout\userbase.html";i:1558517063;s:50:"D:\Web\www.tp6.com\app\web\view\layout\header.html";i:1561797773;s:47:"D:\Web\www.tp6.com\app\web\view\layout\top.html";i:1561789333;s:48:"D:\Web\www.tp6.com\app\web\view\layout\left.html";i:1562120423;s:50:"D:\Web\www.tp6.com\app\web\view\layout\footer.html";i:1558163236;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="/static/admin/images/chuyin.ico">
<title>会员中心 - 51空包网</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="51kongbaoo">
<link rel="stylesheet" type="text/css" href="/static/web/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/web/css/index.css" />
<link rel="stylesheet" type="text/css" href="/static/web/css/user.css" />	
<script type="text/javascript" src="/static/web/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/static/web/js/layer.js"></script>

<style>
	.m6{ text-align:right; width:130px !important;}
</style>

</head>
<body>
<div class="header">
	<ul>
        <div class="head-l">
            <a href="/" title="空包网">51空包网</a>
        </div>

        <?php if(empty(session('userid')) || ((session('userid') instanceof \think\Collection || session('userid') instanceof \think\Paginator ) && session('userid')->isEmpty())): ?>
        <div class="head-r">
            <a href="<?php echo url('register/index'); ?>">注册会员</a><span>|</span>
            <a href="<?php echo url('login/index'); ?>">会员登录</a><span>|</span>
            <a href="<?php echo url('oauth/call', ['type' => 'qq']); ?>">
				<img src="/static/web/images/login/qq_2.gif" />
			</a>
			<span>|</span>
            <a href="<?php echo url('friends/invitation'); ?>">邀请好友拿奖励</a>
        </div>
        <?php else: ?>
        <div class="head-r">
            <a href="<?php echo url('user/index'); ?>" style="color:#F60"><?php echo session('username'); ?></a><span>|</span>
            <a href="<?php echo url('friends/invitation'); ?>">邀请好友拿奖励</a><span>|</span>
            <a href="<?php echo url('login/logout'); ?>">退出</a>
        </div>
        <?php endif; ?>
	
        <div class="bdsharebuttonbox" style="float:right; margin-left:10px; margin-top:2px;">
        <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_copy" data-cmd="copy" title="分享到复制网址"></a><a href="#" class="bds_more" data-cmd="more"></a>
        </div>
<script>
window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"24"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
</script>
    </ul>
</div>

<div class="top">
    <div class="navbar-header">
    <a class="logo" href="/"></a>
    </div>
    
    <div class='nav'>
        <ul>
            <li class="selected"><a href="/">首页</a></li>
            <li><a href="http://www.51liuliangshenqi.com/" target="_blank" style="color:#F00;">刷流量</a></li>
            <li><a href="<?php echo url('bag/buy_pl'); ?>">快递下单</a></li>
            <li><a href="<?php echo url('pay/index'); ?>">在线充值</a></li>
            <li><a href="<?php echo url('user/vip'); ?>">会员升级</a></li>
            <li><a href="<?php echo url('order/index'); ?>"><font color="#FF0000">底单申诉</font></a></li>
            <li><a href="<?php echo url('help/index'); ?>">帮助中心</a></li>
        </ul>
	</div>
</div>

<div class="user">
	<div class="user_index">
    	<div class="user_top">
	<div class="user_top_left">
    	<i><img src="/static/upload//user_photo.jpg" /></i>
    	<p><font color="#32cb63"><?php echo htmlentities($user['username']); ?></font>，欢迎您！</p>
        <p>
			会员等级：
			<?php switch($user['level']): case "2": ?><span class="level2">黄金会员</span><?php break; case "3": ?><span class="level3">铂金会员</span><?php break; case "4": ?><span class="level4">钻石会员</span><?php break; default: ?>普通会员
			<?php endswitch; if($user['level'] != 4): ?>
			<a href="<?php echo url('user/vip'); ?>">升级会员</a>
			<?php endif; ?>
		</p>
        <p>上次登录时间：<?php echo get_date($user['last_login_time']); ?></p>
    </div>
    <div class="user_top_right">
    	<p>账户余额：<span><?php echo htmlentities($user['money']); ?></span> 元 <a href="<?php echo url('mingxi/index'); ?>">资金明细</a></p>
        <p>冻结金额：<?php echo htmlentities($user['frost_money']); ?> 元 <font color="#999999">（提现时金额将被冻结）</font></p>
        <p>消费金额：<?php echo htmlentities($user['expense_money']); ?> 元</p>
    </div>
    <div class="user_top_right2">
    	<p><a class="pay" href="<?php echo url('pay/index'); ?>">充值</a></p>
    	<p><a class="tix" href="<?php echo url('user/tixian'); ?>">提现</a></p>
    </div>

</div>
<div class="clear"></div>

		<div class="user_left">
	
    <dl>
    	<dt>补单推荐</dt>
        <dd><a href="http://www.51lingla.com" target="_blank" style="color:#ff0000">淘宝补单发布</a></dd>
        <dd><a href="http://www.51baobeio.com" target="_blank" style="color:#ff0000">天猫补单发布</a></dd>


    </dl>

	<dl>
    	<dt>我的业务</dt>
        <dd><a href="<?php echo url('bag/buy_pl'); ?>">批量购买空包</a><span><a href="<?php echo url('bag/buy'); ?>">单个购买</a></span></dd>
        <dd><a href="<?php echo url('bag/index'); ?>">已买到的空包</a></dd>
        <dd><a href="<?php echo url('user/address'); ?>">设置发货地址</a></dd>
        <dd><a href="<?php echo url('order/index'); ?>">申请底单</a></dd>
        <dd><a href="<?php echo url('order/record'); ?>">已申请的底单</a></dd>
    </dl>
    
    <dl>
    	<dt>财务管理</dt>
        <dd><a href="<?php echo url('pay/index'); ?>">在线充值</a></dd>
        <dd><a href="<?php echo url('pay/record'); ?>">充值记录</a></dd>
        <dd><a href="<?php echo url('mingxi/index'); ?>">资金明细</a></dd>
        <dd><a href="<?php echo url('tixian/account'); ?>">绑定提现帐号</a></dd>
        <dd><a href="<?php echo url('tixian/index'); ?>">我要提现</a></dd>
        <dd><a href="<?php echo url('tixian/record'); ?>">提现记录</a></dd>
    </dl>
    
    <dl>
    	<dt>邀请奖励</dt>
    	<dd><a href="<?php echo url('friends/index'); ?>">我的好友</a></dd>
        <dd><a href="<?php echo url('friends/reward'); ?>">奖励明细</a></dd>
        <dd><a href="<?php echo url('friends/invitation'); ?>">获取邀请好友链接</a></dd>
    </dl>
    
    <dl>
    	<dt>帐号管理</dt>
        <dd><a href="<?php echo url('user/vip'); ?>">升级会员</a></dd>
        <dd><a href="<?php echo url('user/apilogin'); ?>">绑定第三方帐号</a></dd>
        <dd><a href="<?php echo url('user/info'); ?>">修改资料</a></dd>
        <dd><a href="<?php echo url('user/pass'); ?>">修改密码</a></dd>

    </dl>
</div>


        <div class="user_right">
        	<div class="user_title">会员中心</div>
            
            <?php if(!(empty($user['password_m']) || (($user['password_m'] instanceof \think\Collection || $user['password_m'] instanceof \think\Paginator ) && $user['password_m']->isEmpty()))): ?>
            <div class="user_gg_2">
            	<font color="#FF0000">您使用的第三方帐号登录，还未设置本站登录密码，请尽快去修改一下您的原始密码。</font> <a href="<?php echo url('user/pass'); ?>">修改密码</a>
            </div>
            <?php endif; if(empty($user['email']) || (($user['email'] instanceof \think\Collection || $user['email'] instanceof \think\Paginator ) && $user['email']->isEmpty())): ?>
            <div class="user_gg_2">
            	<font color="#FF0000">您还没有设置邮箱帐号，请尽快去添加一个邮箱帐号。</font> <a href="<?php echo url('user/info'); ?>">添加邮箱</a>
            </div>
			<?php endif; ?>
            
        	<div class="user_gg">
            	<p>好消息，即日起充值满就送会员活动开始啦：</p>
            	<p style="color:#f00">
                    一次性充值188元，送永久<span class="level2">黄金会员</span><br />
                    一次性充值388元，送永久<span class="level3">铂金会员</span><br />
                    一次性充值588元，送永久<span class="level4">钻石会员</span>
                </p>
                <p>会员等级越高，下单价格越优惠，以及其他各种优惠。 <a href="<?php echo url('user/pay'); ?>">马上去充值</a></p>
            </div>
            
            <?php if(empty($check) || (($check instanceof \think\Collection || $check instanceof \think\Paginator ) && $check->isEmpty())): ?>
            <div>
            	<a href="http://www.51liuliangshenqi.com/?51kongbaoo" target="_blank" style="margin-right: 5px; margin-left:10px;">
					<img src="/static/upload//51liuliangshenqi-320.jpg" />
				</a>
                <a href="http://www.51liuliangshenqi.com/SQrobot?51kongbaoo" target="_blank" style="margin-right: 5px;">
					<img src="/static/upload//51liuliangshenqi-sq-320.jpg?20181220" />
				</a>
                <a target="_blank" href="http://www.51lingla.com/?51kongbaoo">
					<img src="/static/upload//51320-1.jpg" />
				</a>
            </div>

            <?php endif; ?>
            
        	<div class="user_kdjg">
                
                <ul class="mz">
                    <li class="m1">快递类型</li>
                    <li class="m2"><?php echo $user['level']==1 ? '<span>普通会员</span>'  :  '普通会员'; ?></li>
                    <li class="m3"><?php echo $user['level']==2 ? '<span>黄金会员</span>'  :  '黄金会员'; ?></li>
                    <li class="m4"><?php echo $user['level']==3 ? '<span>铂金会员</span>'  :  '铂金会员'; ?></li>
                    <li class="m5"><?php echo $user['level']==4 ? '<span>钻石会员</span>'  :  '钻石会员'; ?></li>
                    <li class="m6">下单</li>
                </ul>
                
                <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <ul>
                    <li class="m1"><?php echo htmlentities($vo['name']); ?></li>
                    
                    <li class="m2"><?php if($user['level'] == 1): ?><span><?php echo htmlentities($vo['level1']); ?>元</span><?php else: ?><?php echo htmlentities($vo['level1']); ?>元<?php endif; ?></li>
                    <li class="m3"><?php if($user['level'] == 2): ?><span><?php echo htmlentities($vo['level2']); ?>元</span><?php else: ?><?php echo htmlentities($vo['level2']); ?>元<?php endif; ?></li>
                    <li class="m4"><?php if($user['level'] == 3): ?><span><?php echo htmlentities($vo['level3']); ?>元</span><?php else: ?><?php echo htmlentities($vo['level3']); ?>元<?php endif; ?></li>
                    <li class="m5"><?php if($user['level'] == 4): ?><span><?php echo htmlentities($vo['level4']); ?>元</span><?php else: ?><?php echo htmlentities($vo['level4']); ?>元<?php endif; ?></li>
                    <li class="m6"><a href="<?php echo url('bag/buy'); ?>">下单购买</a></li>
                    </ul>
                    <ul>
                    	<li class="m8"><?php echo htmlentities($vo['explain']); ?></li>
                    </ul>
                <?php endforeach; endif; else: echo "" ;endif; ?>
                
                	<ul>
                    <li class="m1"></li>
                    
                    <li class="m2"><?php if($user['level'] == 1): ?><span>您的价格↑</span><?php endif; ?></li>
                    <li class="m3"><?php if($user['level'] < 2): ?><a href="<?php echo url('User/vip'); ?>">升级黄金</a><?php elseif($user['level'] == 2): ?><span>您的价格↑</span><?php endif; ?></li>
                    <li class="m4"><?php if($user['level'] < 3): ?><a href="<?php echo url('User/vip'); ?>">升级铂金</a><?php elseif($user['level'] == 3): ?><span>您的价格↑</span><?php endif; ?></li>
                    <li class="m5"><?php if($user['level'] < 4): ?><a href="<?php echo url('User/vip'); ?>">升级钻石</a><?php elseif($user['level'] == 4): ?><span>您的价格↑</span><?php endif; ?></li>
                    <li class="m6"></li>
                    </ul>
					
            </div>
            
            <div class="clear"></div>

        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>

<div id="rightButton" style="right: 0px;">
    <ul id="right_ul">
        <li id="right_qq" class="right_ico" show="qq" hide="tel"></li>
        <!--<li id="right_tel" class="right_ico" show="tel" hide="qq"></li>-->
        <li id="right_tip" class="png" style="top: -10px; display: none;">
            <!--<p class="flagShow_p1 flag_tel" style="display: none;">联系电话</p>
            <p class="flagShow_p2 flag_tel line91" style="display: none;">170-1730-2254</p>-->
            <p class="flagShow_p1 flag_qq" style="display: block;">在线客服</p>
            <p class="flagShow_p2 flag_qq" style="display: block;"><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=99399683&amp;site=qq&amp;menu=yes" target="_blank"><img border="0" src="/static/web/images/onlineQQ.png"></a> <span>99399683</span></p>
        </li>
        <li>
			<div id="backToTop" style="display: none;"><a href="javascript:;" onfocus="this.blur();" class="backToTop_a png"></a></div>
		</li>
    </ul>
</div>

<script type="text/javascript" src="/static/web/js/tab.js"></script>


<div class="clear"></div>
<div class="footer">
	<div class="about">
    	<a href="<?php echo url('help/view', ['id'=>'445']); ?>" target="_blank">关于我们</a>
        <a href="<?php echo url('help/view', ['id'=>'444']); ?>" target="_blank">合作洽谈</a>
		<a href="<?php echo url('help/view', ['id'=>'443']); ?>" target="_blank">客服中心</a>
		<a href="<?php echo url('help/view', ['id'=>'442']); ?>" target="_blank">联系我们</a>
		客服QQ：99399683 工作时间:9:00-21:00
    </div>
	<div class="copyright">&copy; 2016 <a href="http://www.51kongbaoo.com">51空包网</a> www.51kongbaoo.com 粤ICP备16069954号-1 Powered by kongbao. 使用1280x720以上的分辨率能更好的使用本站购买空包 <script src="https://s95.cnzz.com/z_stat.php?id=4289049&web_id=4289049" language="JavaScript"></script></div>

    <div class="footer-m4">
        <ol>
            <li class="footer-m4-1"><a href="javascript:void(0)" target="_blank"></a></li>
            <li class="footer-m4-3"><a href="javascript:void(0)" target="_blank"></a></li>
            <li class="footer-m4-4"><a href="javascript:void(0)" target="_blank"></a></li>
            <li class="footer-m4-6"><a href="javascript:void(0)" target="_blank"></a></li>
            <li class="footer-m4-5"><a herf="javascript:void(0)" target="_blank"></a></li>
        </ol>
    </div>
    
</div>
</body>
</html>