<?php /*a:2:{s:52:"D:\Web\www.kongbao.com\app\admin\view\home\info.html";i:1648730642;s:54:"D:\Web\www.kongbao.com\app\admin\view\layout\base.html";i:1648730642;}*/ ?>
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
		<table class="layui-table" lay-size="lg" lay-skin="line">
		  <thead>
			<tr>
			  <th colspan="2">管理员信息</th>
			</tr> 
		  </thead>
		  <tbody>
			<tr>
			  <td width="150" align="right"><strong>管理员名称：</strong></td>
			  <td><?php echo htmlentities($admin['name']); ?></td>
			</tr>
			<tr>
			  <td align="right" class="ruiwen"><strong>角色：</strong></td>
			  <td>
				<?php foreach($adminRole as $value): ?>
				<?php echo htmlentities($value); ?>、
				<?php endforeach; ?>
			  </td>
			</tr>
			<tr>
			  <td width="150" align="right"><strong>真实名字：</strong></td>
			  <td><?php echo htmlentities($admin['real_name']); ?></td>
			</tr>
			
			<tr>
			  <td width="150" align="right"><strong>QQ：</strong></td>
			  <td><?php echo htmlentities($admin['qq']); ?></td>
			</tr>
			
			<tr>
			  <td width="150" align="right"><strong>登录次数：</strong></td>
			  <td><?php echo htmlentities((isset($admin['login_num']) && ($admin['login_num'] !== '')?$admin['login_num']:0)); ?></td>
			</tr>
			<tr>
			  <td width="150" align="right"><strong>上次登录时间：</strong></td>
			  <td><?php echo date("Y-m-d H:i:s", $admin['last_login_time']); ?></td>
			</tr>
			<tr>
			  <td width="150" align="right"><strong>上次登录IP：</strong></td>
			  <td><?php echo htmlentities((isset($admin['login_ip']) && ($admin['login_ip'] !== '')?$admin['login_ip']:0)); ?></td>
			</tr>
			<tr>
			  <td width="150" align="right"><strong>注册时间：</strong></td>
			  <td><?php echo date("Y-m-d H:i:s", $admin['create_time']); ?></td>
			</tr>
			<tr>
			  <td align="right"><strong>登录状态：</strong></td>
			  <td><?php echo $admin['status']==1 ? '正常'  :  '禁止'; ?> </td>
			</tr>
		  </tbody>
		</table>
    </div>
	<!-- <textarea id="demo" style="display: none;"></textarea> -->

  </div>

  <script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script> 
  <script>
	layui.use(['jquery', 'layer','table','flow','form'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		
		//监听提交
		form.on('submit(formdemo)', function(data){
			layer.msg(json.stringify(data.field));
			return false;
		});
		
	});
	
  </script>
  <script>

layui.use('layedit', function(){
  var layedit = layui.layedit;
  
    layedit.set({
	  uploadImage: {
		url: "<?php echo url('upload/upload_layui'); ?>" //接口url
	  }
	});
  
  layedit.build('demo'); //建立编辑器
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