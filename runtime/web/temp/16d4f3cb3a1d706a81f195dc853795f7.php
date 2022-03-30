<?php /*a:4:{s:48:"D:\Web\www.tp6.com\app\web\view\login\index.html";i:1559291313;s:48:"D:\Web\www.tp6.com\app\web\view\layout\base.html";i:1561789172;s:50:"D:\Web\www.tp6.com\app\web\view\layout\header.html";i:1561797773;s:50:"D:\Web\www.tp6.com\app\web\view\layout\footer.html";i:1558163236;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="/static/admin/images/chuyin.ico">
<title>会员登录 - 51空包网</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="51kongbaoo">
<link rel="stylesheet" type="text/css" href="/static/web/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/web/css/index.css" />
<script type="text/javascript" src="/static/web/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/static/web/js/layer.js"></script>

<link rel="stylesheet" type="text/css" href="/static/web/css/login.css" />

<script type="text/javascript">
function register_submit(){
	var buy_name = $("#buy_name").val();
	var buy_pass = $("#buy_pass").val();
	var code = $("#code").val();


	if(!buy_name){
		layer.tips('用户名未填写', '#buy_name', {
		  tips: [1, '#f25f55'],
		  time: 4000
		});
		return;
	}

	if(!buy_pass){
		
		layer.tips('登录密码未填写', '#buy_pass', {
		  tips: [1, '#f25f55'],
		  time: 4000
		});

		return;	
	}

	if(!code){
		
		layer.tips('验证码未填写', '#code', {
		  tips: [1, '#f25f55'],
		  time: 4000
		});
			
		return;
	}

	
	$.ajax({
		url: "<?php echo url(); ?>",
		type: 'POST',
		data:{buy_name:buy_name,buy_pass:buy_pass,code:code},
		dataType: 'json',
		success: function(data){
			//alert(data);
			if(data.code == 2)
			{
				layer.msg(data.msg);
				var code_url = $('#codes').attr('src');
				$('#codes').attr('src', code_url + '?1');
				return false;
				
			}else if(data.code == 3)
			{
				layer.msg('登录成功', {icon:1});
				setTimeout(function(){
					window.location = "<?php echo url('home/index'); ?>";
				}, 500);
			}
			
		}
	});
	
}
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

<div class="reg">
	<div class="center">
        <div class="login-l"></div>
        
        <div class="login-r">
            <h3>欢迎回来</h3>

            <p>
            <i>用户名</i>
            <input class="text" id="buy_name" name="buy_name" type="text" value="" tabindex="1" size="30" autocomplete="off">
            </p>
            
            <p>
            <i>密　码</i>
            <input class="text" id="buy_pass"  name ="buy_pass" type="password" tabindex="2" autocomplete="off">
            </p>

            <p>
            <i>验证码</i>
            <input onKeyDown="javascript:if(event.keyCode==13)register_submit();" id="code" type="text" class="text_code" tabindex="4" autocomplete="off">
			<a href="javascript:;">
				<img src="<?php echo captcha_src(); ?>" alt="captcha" class="layadmin-user-login-codeimg" id="codes" onclick="this.src = this.src + '?1'" width="86" height="34">
			</a>
            <a href="javascript:;" onClick="document.getElementById('codes').src = document.getElementById('codes').src + '?1'" >换一个</a>

            </p>
            
            <h4>还没有账号？<a href="<?php echo url('register/index'); ?>">马上注册</a> <a href="<?php echo url('login/findpass'); ?>" style="color:#ff0000;">忘记密码</a></h4>
            
            <p><a href="javascript:register_submit();" class="reg-btn">登 录</a></p>

            <p style="margin-top:30px; color:#999">----------------使用第三方账号快速登录----------------</p>
            
			<p><a href="<?php echo url('Oauth/call', ['type'=>'qq']); ?>"><img src="/static/web/images/login/qq_7.png" /></a></p>
			
        </div>
    
    
    </div>
    <div class="clear"></div>
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