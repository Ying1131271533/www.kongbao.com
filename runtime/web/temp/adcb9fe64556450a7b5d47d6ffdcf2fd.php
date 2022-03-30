<?php /*a:6:{s:48:"D:\Web\www.tp6.com\app\web\view\order\index.html";i:1617443359;s:52:"D:\Web\www.tp6.com\app\web\view\layout\userbase.html";i:1558517063;s:50:"D:\Web\www.tp6.com\app\web\view\layout\header.html";i:1561797773;s:47:"D:\Web\www.tp6.com\app\web\view\layout\top.html";i:1561789333;s:48:"D:\Web\www.tp6.com\app\web\view\layout\left.html";i:1562120423;s:50:"D:\Web\www.tp6.com\app\web\view\layout\footer.html";i:1558163236;}*/ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="icon" href="/static/admin/images/chuyin.ico">
<title>申请底单 - 51空包网</title>
<meta name="keywords" content="">
<meta name="description" content="">
<meta name="author" content="51kongbaoo">
<link rel="stylesheet" type="text/css" href="/static/web/css/style.css" />
<link rel="stylesheet" type="text/css" href="/static/web/css/index.css" />
<link rel="stylesheet" type="text/css" href="/static/web/css/user.css" />	
<script type="text/javascript" src="/static/web/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/static/web/js/layer.js"></script>

<link rel="stylesheet" type="text/css" href="/static/web/layui/css/layui.css" />
<script type="text/javascript" src="/static/web/layui/layui.js"></script>
<script type="text/javascript">
function getid(){
	var number = $('#number').val();
	$.ajax({
		url: "<?php echo url('bag_info'); ?>",
		type: 'POST',
		data:{number:number},
		dataType: 'json',
		success: function(data){
		
			if(data.code == 1)
			{
				return layer.alert('单号有误或者您没有购买这个单号。');
			}
			
			$('#kdname').val(data.kd_name);
			$('#fname').val(data.addresser);
			$('#fphone').val(data.phone);
			$('#faddress').val(data.province+data.city+data.county+data.address);
			$('#sname').val(data.sname);
			$('#sphone').val(data.sphone);
			$('#saddress').val(data.saddress);
			$('#ftime').val(data.time_date);
			$('#goods').val(data.goods_name);
			$('#kg').val(data.kg);
			$('#kd_id').val(data.kd_id);
			
		}
	});
}

function chek(form)
{
	if(form.kdname.value==''){
		layer.msg('请选择快递类型！', {icon:2});
		form.kdname.focus();
		return false;
	}
	
	if(form.number.value==''){
		layer.msg('快递单号不能为空！', {icon:2});
		form.number.focus();
		return false;
	}
	
	if(form.image.value==''){
		layer.msg('请上传降权截图！', {icon:2});
		form.number.focus();
		return false;
	}
	
	if(form.fname.value==''){
		layer.msg('发货人姓名不能为空！', {icon:2});
		return false;
	}
	
	if(form.fphone.value==''){
		layer.msg('发货人电话不能为空！', {icon:2});
		return false;
	}
	
	if(form.faddress.value==''){
		layer.msg('发货人地址不能为空！', {icon:2});
		return false;
	}
	
	if(form.sname.value==''){
		layer.msg('收货人姓名不能为空！', {icon:2});
		return false;
	}
	
	if(form.sphone.value==''){
		layer.msg('收货人电话不能为空！', {icon:2});
		return false;
	}
	
	if(form.saddress.value==''){
		layer.msg('收货人地址不能为空！', {icon:2});
		return false;
	}
	
	if(form.ftime.value==''){
		layer.msg('发货时间不能为空！', {icon:2});
		return false;
	}
	
	if(form.goods.value==''){
		layer.msg('商品名称不能为空！', {icon:2});
		return false;
	}
	
	if(form.kg.value==''){
		layer.msg('商品重量不能为空！', {icon:2});
		return false;
	}
	
	if(form.image.value==''){
		layer.msg('截图不能为空', {icon:2});
		return false;
	}
	
	
	return true;

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
        
        	<div class="user_title">申请底单</div>
		
	   
			<div class="user_ts" style="margin:20px 10px;">
				<p>申请底单须知：</p>
				<p class="red">申请之前请检查下淘宝降权单号是否有变，确认后再申请底单。</p>
				<p class="red">提交申请后，客服将在24小时内为您处理，请正确上传降权截图，否则一律不处理。 <a href="<?php echo url('article/view', ['id' => '458']); ?>" target="_blank">什么是降权截图？</a></p>
				
				<p>
				( 注释:只要不刷得太明显都能通过。比如代付刷、红包刷、自己登陆小号购买刷、无假聊等等是肯定过不了的，所以自己对刷法有信心的来申请，<br />要不然申请了底单可能也是徒劳。)</p>
				
			</div>
			
			<div class="vipmoney">
				<span>普通会员：<em>0.5</em> 元/单</span>
				<span>黄金会员：<em>0</em> 元/单</span>
				<span>铂金会员：<em>0</em> 元/单</span>
				<span>钻石会员：<em>0</em> 元/单</span>
			</div>
			
			<form action="<?php echo url(); ?>" method="post" enctype="multipart/form-data" onsubmit="return chek(this)">
				<div class="user_order">
					<ul>
					
					
					<li>
					　快递单号：<input id="number" name="number" type="text" class="val" value="" /> <a href="javascript:getid()" class="getid">获取单号信息</a> <em>输入快递单号，点击获取单号信息即可获得以下所有信息</em>
					</li>
					
					<li>　快递类型：<input id="kdname" name="kdname" type="text"  class="val" value="" /></li>
					<li>发货人姓名：<input id="fname" name="fname" type="text"  class="val" value="" /></li>
					<li>发货人手机：<input id="fphone" name="fphone" type="text" class="val" value="" /></li>
					<li>发货人地址：<input id="faddress" name="faddress" type="text" class="val" value="" style="width:500px" /></li>
					<li>收货人姓名：<input id="sname" name="sname" type="text" class="val" value="" /></li>
					<li>收货人手机：<input id="sphone" name="sphone" type="text" class="val" value="" /></li>
					<li>收货人地址：<input id="saddress" name="saddress" type="text" class="val" value=""  style="width:500px" /></li>
					<li>　发货日期：<input id="ftime" name="ftime" type="text" class="val" value="" /> <em>格式：2015-08-11</em></li>
					<li>　商品名称：<input id="goods" name="goods" type="text" class="val" value="" /></li>
					<li>　商品重量：<input id="kg" name="kg" type="text" class="val" value="" /></li>
					
					
					
					
					<li>
					　降权截图：
						<button type="button" class="layui-btn" id="test1">上传图片</button>
						<input type="hidden" id="image" name="image" value="" />
						<em>【<a href="<?php echo url('article/view', ['id'=>'458']); ?>" target="_blank" style="color:#F00; font-weight:bold;">降权截图样式</a>】 请正确上传截图，否则不予通过，图片允许后缀：.jpg .gif .png .jpeg </em>
					</li>

					
					<li>
						<input type="submit" class="qr" value="提交申请"  />
						<input type="hidden" name="kd_id" id="kd_id">
					</li>
					</ul>
				</div>
			</form>
			

			<div class="clear"></div>
			

        
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<script>
	layui.use(['upload', 'layer', 'jquery'], function(){
		var upload = layui.upload;
		
		//执行实例
		var uploadInst = upload.render({
			elem: '#test1' //绑定元素
			,url: "<?php echo url('upload/upload_img'); ?>" //上传接口
			,done: function(res){
				//上传完毕回调
				if(res.code != 0)
				{
					layer.msg(res.msg, {icon:2});
					return false;
				}
				
				$('input[name="image"]').val(res.image);
				layer.msg(res.msg, {icon:1});
				return false;
			}
			,error: function(){
				//请求异常回调
				layer.msg('上传失败', {icon:2});
				return false;
			}
		});
		
		
	});
</script>

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