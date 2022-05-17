<?php /*a:4:{s:51:"D:\Web\www.kongbao.com\app\web\view\home\index.html";i:1561797773;s:52:"D:\Web\www.kongbao.com\app\web\view\layout\base.html";i:1620646555;s:54:"D:\Web\www.kongbao.com\app\web\view\layout\header.html";i:1561797773;s:54:"D:\Web\www.kongbao.com\app\web\view\layout\footer.html";i:1558163236;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="/static/admin/images/chuyin.ico">
<title>空包网_空包代发_代发快递空包 - 51空包网</title>
<meta name="keywords" content="空包网,代发空包,快递单号,快递空包,空包单号,空包代发,51空包网">
<meta name="description" content="51空包网提供空包单号,快递单号,空包代发等各大快递单号出售,51空包全部记录真实有效,
空包网全国地址任意发,24小时自助下单,快速免费提供底单！最便宜最专业的空包单号网空包代发平台,快递单号一单一用安全可靠!">
<meta name="author" content="51kongbaoo">
<link rel="stylesheet" type="text/css" href="/static/web/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/web/css/index.css" />
<script type="text/javascript" src="/static/web/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/static/web/js/layer.js"></script>

<script type="text/javascript">
function register_submit(){
	var username = document.getElementById("username").value;
	var password=document.getElementById("password").value;
	var code=document.getElementById("code").value;
	var code_img=document.getElementById("mcImgVC");
	$.ajax({
		url: "<?php echo url('login/index'); ?>",
		type: 'POST',
		data:{buy_name:username,buy_pass:password,code:code},
		dataType: 'json',
		success: function(data){
			
			if(data.code == 2)
			{
				layer.msg(data.msg);
				var code_url = $('#codes').attr('src');
				$('#codes').attr('src', code_url + '?1');
				return false;
				
			}else if(data.code == 3)
			{
				window.location = "<?php echo url('user/index'); ?>";
			}window.location="<?php echo url('user/index'); ?>";
			
		}
	});
}
</script>
<script type="text/javascript" src="/static/web/js/jquery.marquee.js"></script>
<script type="text/javascript">  
$(function(){      
	$("#marquee").marquee({
		yScroll: "bottom",
		showSpeed: 850,
		scrollSpeed: 12 ,
 		pauseSpeed: 5000
 });  
});  
</script>

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

<script type="text/javascript" src="/static/web/js/index.js"></script>
<!-- 幻灯片 -->
<div class="bg">
	<div class="flash">
	<?php if(empty(session('userid')) || ((session('userid') instanceof \think\Collection || session('userid') instanceof \think\Paginator ) && session('userid')->isEmpty())): ?>
		<div class="indexlogin">
			<h3>会员登录<a href="<?php echo url('Register/index'); ?>">免费注册</a></h3>
			<p><input id="username" type="text" class="username" placeholder="会员帐号"/></p>
			<p><input id="password" type="password" class="password" placeholder="登录密码"/></p>
			<p>
				<input id="code" type="text" class="text_code" autocomplete="off" placeholder="验证码">
				<a href="javascript:;">
				<img src="<?php echo captcha_src(); ?>" alt="captcha" class="layadmin-user-login-codeimg" id="codes" onclick="this.src = this.src + '?1'" width="86" height="34">
			</a>
			</p>
			<p style="margin-top:10px; margin-bottom:6px;"><a href="javascript:register_submit();" class="reg-btn">登 录</a></p>
			<p><a href="<?php echo url('oauthsscall', ['type' => 'qq']); ?>"><img src="/static/web/images/login/qq_7.png" /></a></p>
		</div>
	<?php else: ?>
		<div class="indexlogin2">
			<h3>欢迎回来</h3>
			<p>用户名：<?php echo session('username'); ?></p>
			<p><a href="<?php echo url('user/index'); ?>">会员中心</a><a href="<?php echo url('user/pass'); ?>">修改密码</a><a href="<?php echo url('user/info'); ?>">修改资料</a></p>
			<p><a href="<?php echo url('user/pay'); ?>">在线充值</a><a href="<?php echo url('user/mingxi'); ?>">资金明细</a><a href="<?php echo url('vip/index'); ?>">升级会员</a></p>
			<p><a href="<?php echo url('user/buy_pl'); ?>">购买空包</a><a href="<?php echo url('user/bag'); ?>">已买空包</a><a href="<?php echo url('order/index'); ?>">申请底单</a></p>
			<p><a href="<?php echo url('login/logout'); ?>" class="reg-btn">退出登录</a></p>
		</div>
	<?php endif; ?>
		<div class="banner">
			<div class="banner-btn" style="display: none;">
			<a href="javascript:;" class="prevBtn" style="opacity: 0.3;"><i></i></a> 
			<a href="javascript:;" class="nextBtn"><i></i></a>
			</div>
			<ul class="banner-img" style="">
				
				<li><a href="<?php echo url('user/buy'); ?>" target="_blank"><img src="/static/upload/banner3.jpg" width="1200" height="386"></a></li>
				<li><a href="<?php echo url('user/pay'); ?>" target="_blank"><img src="/static/upload/banner4.jpg?20170606" width="1200" height="386"></a></li>
				<li><a href="<?php echo url('friends/index'); ?>" target="_blank"><img src="/static/upload/banner5.jpg" width="1200" height="386"></a></li>
			</ul>
			<ul class="banner-circle"></ul>
		</div>
	</div>
</div>
<!-- /幻灯片 -->

<div class="gdbg" >
	
	<ul id="marquee">
		<div class="newgd">51空包网最新下单会员：</div>
		
		<li>
			<?php if(is_array($gd) || $gd instanceof \think\Collection || $gd instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($gd) ? array_slice($gd,1,3, true) : $gd->slice(1,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<span><?php echo htmlentities($vo['name']); ?> 已下单购买 <font color="#FFFF00"><?php echo htmlentities($vo['kd']); ?></font> <?php echo htmlentities($vo['create_time']); ?></span>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</li>
		<li>
			<?php if(is_array($gd) || $gd instanceof \think\Collection || $gd instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($gd) ? array_slice($gd,4,3, true) : $gd->slice(4,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<span><?php echo htmlentities($vo['name']); ?> 已下单购买 <font color="#FFFF00"><?php echo htmlentities($vo['kd']); ?></font> <?php echo htmlentities($vo['create_time']); ?></span>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</li>
		<li>
			<?php if(is_array($gd) || $gd instanceof \think\Collection || $gd instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($gd) ? array_slice($gd,7,3, true) : $gd->slice(7,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<span><?php echo htmlentities($vo['name']); ?> 已下单购买 <font color="#FFFF00"><?php echo htmlentities($vo['kd']); ?></font> <?php echo htmlentities($vo['create_time']); ?></span>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</li>
		<li>
			<?php if(is_array($gd) || $gd instanceof \think\Collection || $gd instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($gd) ? array_slice($gd,10,3, true) : $gd->slice(10,3, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
			<span><?php echo htmlentities($vo['name']); ?> 已下单购买 <font color="#FFFF00"><?php echo htmlentities($vo['kd']); ?></font> <?php echo htmlentities($vo['create_time']); ?></span>
			<?php endforeach; endif; else: echo "" ;endif; ?>
		</li>
	</ul>
</div>

<!-- 宣传语 -->
<div class="slogan">
   <div class="slogan-con">
	<div class="sl-cons img1">
	  <p class="slc-title">顶级空包供应商</p>
	  <p class="slc-caption">顶级渠道商，快递空包单号价格业内最低，<br />价格体现实力！</p>
	</div>
	<div class="sl-cons img2">
	  <p class="slc-title">7X24小时在线自动充值</p>
	  <p class="slc-caption">支持支付宝、财付通全自动充值，<br />一步到账，无需填写交易号。</p>
	</div>
	<div class="sl-cons img3">
	  <p class="slc-title">一单一用，真实物流</p>
	  <p class="slc-caption">真实淘宝、京东跟踪记录,<br />提供真实底单保证一单一用，安全可靠!</p>
	</div>
  </div>
</div>
<!-- /宣传语 -->
  
<div class="fbg">
    <div class="center"> 
    
    <!-- 快递推荐 -->
    <div class="index-hot">
        <div class="index-title">快递推荐<span>真实淘宝跟踪记录,提供真实底单保证一单唯一使用，安全可靠!</span></div>
            <ul>
                <li>           
                <p class="kdlogo"><img src="/static/upload//kb/56f17112af3b6.jpg" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>龙邦速递(淘宝天猫)</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">2.00</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">1.90</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">1.80</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">龙邦速递（淘宝天猫）全国发全国，官网和淘宝都有物流记录，物流完美。</p>
                </li><li>           
                <p class="kdlogo"><img src="/static/upload//kb/yt124515666.jpg" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>圆通快递(淘宝天猫)</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">2.70</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">2.65</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">2.60</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">圆通快递（淘宝天猫）全国发全国，官网和淘宝都有物流记录，物流完美。</p>
                </li><li>           
                <p class="kdlogo"><img src="/static/upload//kb/56f17125bfdc9.jpg" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>天天快递(淘宝天猫)</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">2.20</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">2.10</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">2.00</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">天天快递（支持淘宝、天猫、阿里）全国发全国，官网和淘宝都有物流记录，物流完美。</p>
                </li><li>           
                <p class="kdlogo"><img src="/static/upload//kb/yf115612345.jpg" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>亚风快递(淘宝天猫)</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">1.80</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">1.70</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">1.60</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">亚风快递（淘宝天猫）全国发全国，在淘宝后台请选择"亚风-全国-配送"。</p>
                </li><li>           
                <p class="kdlogo"><img src="/static/upload//kb/ys851234856.jpg" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>优速快递(淘宝天猫)</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">2.10</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">2.00</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">1.90</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">优速快递（淘宝天猫）全国发全国，官网和淘宝都有物流记录，物流完美。</p>
                </li><li>           
                <p class="kdlogo"><img src="/static/upload//kb/kjkdasd.jpg" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>快捷快递(淘宝天猫)</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">2.00</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">1.90</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">1.80</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">快捷快递（淘宝天猫）全国发全国，官网和淘宝都有物流记录，物流完美。</p>
                </li><li>           
                <p class="kdlogo"><img src="/static/upload//kb/sto1251251.jpg" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>申通快递(淘宝天猫)</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">2.30</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">2.20</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">2.10</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">申通快递（淘宝天猫）全国发全国，官网和淘宝都有物流记录，物流完美。</p>
                </li><li>           
                <p class="kdlogo"><img src="/static/upload//kb/bskd523124.jpg	" height="65" width="170" onerror="javascript:this.src='/static/upload/wu.jpg';"/></p>
                <p>百世快递(淘宝天猫)	</p>
                <dl class="levelmoney">
                    <dt><span>黄金会员</span><br/><span class="wow">2.20</span>元/单</dt>
                    <dt><span>铂金会员</span><br/><span class="wow">2.10</span>元/单</dt>
                    <dt style="border-right:none;"><span>钻石会员</span><br/><span class="wow">2.00</span>元/单</dt>
                    <div class="clear"></div>
                </dl>
                <p class="buy"><a class="click-pop" href="/user/buy.html">立即购买</a></p>
                <p class="comm">百世快递（支持淘宝/天猫/阿里）全国发全国，官网和淘宝都有物流记录，物流完美。</p>
                </li>            </ul>
        <div class="clear"></div>
    </div>
    <!-- /快递推荐 -->


    <div class="article">
        <div class="article-l">
            <div class="index-title">电商资讯</div>
            <ul>
                <?php if(is_array($article) || $article instanceof \think\Collection || $article instanceof \think\Paginator): $i = 0; $__LIST__ = $article;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li>
                    <p><a target="_blank" href="<?php echo url('article/view', ['id' => $vo['id']]); ?>"><?php echo htmlentities($vo['title']); ?></a></p>
                    <p class="article-jj"><?php echo htmlentities(msubstr(html_dcode($vo['content']),0,70, 'utf-8', true)); ?></p>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="clear"></div>
        </div>
        
        <div class="article-r">
            <div class="index-title">公告<i><a href="<?php echo url('article/index'); ?>">更多</a></i></div>
            <ul>
                <?php if(is_array($gg) || $gg instanceof \think\Collection || $gg instanceof \think\Paginator): $i = 0; $__LIST__ = $gg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li><a target="_blank" href="<?php echo url('article/view', ['id' => $vo['id']]); ?>"><?php echo htmlentities($vo['title']); ?></a></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="clear"></div>
        </div>
    	<div class="clear"></div>
    </div>
    
    
    </div>
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