<?php /*a:2:{s:48:"D:\Web\www.tp6.com\app\admin\view\user\edit.html";i:1622878564;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>51空包代理</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="/static/admin/layuiadmin/layui/css/layui.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/layuiadmin/style/admin.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/css/style.css" />
	<script type="text/javascript" src="/static/admin/js/common.js"></script>
	
</head>
<body>
	

<div class="layui-fluid">
	<div class="layui-form">
		<form action="<?php echo url(); ?>" method="post" name="example">

			<table class="layui-table" lay-skin="line">
			  <thead>
			  <tr>
				<th colspan="2">修改会员</th>
			  </tr>
			  </thead>
			  <tbody>
			  
			  
			  <tr>
				<td width="150" align="right"><strong>会员ID：</strong></td>
				<td><?php echo htmlentities($list['id']); ?></td>
			  </tr>

			  <tr>
				<td align="right"><strong>用户名：</strong></td>
				<td>
					<?php echo htmlentities($list['username']); ?>
				</td>
			  </tr>

			  <tr>
				<td align="right"><strong>真实姓名：</strong></td>
				<td><div class="layui-input-inline"><input type="text" name="name" value="<?php echo htmlentities($list['name']); ?>" class="layui-input"/></div></td>
			  </tr>

			  <tr>
				<td align="right"><strong>登录密码：</strong></td>
				<td><div class="layui-input-inline"><input type="text" name="password" value="" class="layui-input"/></div> 留空就不修改</td>
			  </tr>

			  <tr>
				<td align="right"><strong>邮箱：</strong></td>
				<td><div class="layui-input-inline"><input type="text" name="email" value="<?php echo htmlentities($list['email']); ?>" class="layui-input"/></div></td>
			  </tr>
			  
			  <tr>
				<td align="right"><strong>QQ：</strong></td>
				<td><div class="layui-input-inline"><input type="text" name="qq" value="<?php echo htmlentities($list['qq']); ?>" class="layui-input"/></div></td>
			  </tr>
			  
			  <tr>
				<td align="right"><strong>电话：</strong></td>
				<td><div class="layui-input-inline"><input type="text" name="phone" value="<?php echo htmlentities($list['phone']); ?>" class="layui-input"/></div></td>
			  </tr>
			  
			  <tr>
				<td align="right"><strong>会员等级：</strong></td>
				<td>
					<div class="layui-form-item">
						<div class="layui-input-block" style="margin-left: 0px;">
							<input name="level" type="radio" value="1" <?php echo $list['level']==1 ? 'checked'  :  ''; ?> title="普通会员 LV1" />
							<input name="level" type="radio" value="2" <?php echo $list['level']==2 ? 'checked'  :  ''; ?> title="黄金会员 LV2" />
							<input name="level" type="radio" value="3" <?php echo $list['level']==3 ? 'checked'  :  ''; ?> title="铂金会员 LV3  " />
							<input name="level" type="radio" value="4" <?php echo $list['level']==4 ? 'checked'  :  ''; ?> title="钻石会员 LV4" />
						</div>
					</div>
				</td>
			  </tr>
			  
			  <tr>
				<td align="right"><strong>金额：</strong></td>
				<td><?php echo htmlentities($list['money']); ?>元 
					<!-- <a href="<?php echo url('mingxi/index', ['uid' => $list['id']]); ?>" class="layui-btn layui-btn-sm layui-btn-normal">资金明细</a> -->
				</td>
			  </tr>
			  
			
			  
			  <tr>
				<td align="right"><strong>登录状态：</strong></td>
				<td>
					<div class="layui-form-item">
						<div class="layui-input-block" style="margin-left: 0px;">
							<input name="isvalid" type="radio" value="1" <?php echo $list['isvalid']==1 ? 'checked'  :  ''; ?> title="正常" />
							<input name="isvalid" type="radio" value="2" <?php echo $list['isvalid']==2 ? 'checked'  :  ''; ?> title="禁止" />
						</div>
					</div>
				</td>
			  </tr>

			  <tr>
				<td></td>
				<td>
					<input type="hidden" name="id" class="layui-btn" value="<?php echo htmlentities($list['id']); ?>" />
					<input type="submit" name="submit" class="layui-btn" value=" 修改员工 " />
				</td>
			  </tr>
			  </tbody>
			</table>
		</form>

	</div>
</div>
<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script> 
<script>
layui.use('form', function(){
  var form = layui.form;
});
</script>

	
	<!-- 打开放大图片窗口 - 容器 -->
	<div id="akali" class="hide layui-layer-wrap" style="display: none;">
		<img src="" id=""/>
	</div>
	<!-- 打开放大图片窗口 - js -->
	<script>
		function open_img(obj)
		{
			layui.use(['jquery', 'layer','table','flow','form'], function(){
				var table = layui.table
				,$ = layui.$
				,layer = layui.layer
				
				var src = obj.src;
				$('#akali img').attr('src', src);
				
				// 获取图片的真实宽高
				$('<img/>').attr("src", $('#akali img').attr("src")).load(function() {

					var pic_real_width = this.width > 1280 ? 1280 : this.width;   // Note: $(this).width() will not
					var pic_real_height = this.height; // work for in memory images.
					
					// 设置图片的宽度不能超过1280px
					$('#akali img').attr('width', pic_real_width);
					
					// 页面层-佟丽娅
					layer.open({
						type: 1,
						title: false,
						closeBtn: 0,
						area: pic_real_width + 'px',
						skin: 'layui-layer-nobg', //没有背景色
						shadeClose: true,
						content: $('#akali')
					});
				});
			});
		}
	</script>
<body>
</html>