<?php /*a:2:{s:49:"D:\Web\www.tp6.com\app\admin\view\order\view.html";i:1562049992;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
		<form action="" method="post" name="example">
			<table class="layui-table" lay-size="lg" lay-skin="line">
			  <thead>
				<tr>
					<th colspan="2">上传底单</th>
				</tr> 
			  </thead>
			  <tbody>
				
				<tr>
				  <td width="150" align="right"><strong>快递公司：</strong></td>
				  <td>
					<div class="layui-input-inline"><?php echo htmlentities($order['kdname']); ?></div>
				  </td>
				</tr>
				
				<tr>
				  <td width="150" align="right"><strong>快递单号：</strong></td>
				  <td>
					<div class="layui-input-inline"><?php echo htmlentities($order['number']); ?></div>
				  </td>
				</tr>
				
				<tr>
				  <td width="150" align="right"><strong>申请时间：</strong></td>
				  <td>
					<div class="layui-input-inline"><?php echo htmlentities($order['create_time']); ?></div>
				  </td>
				</tr>
				
				<tr>
				  <td width="150" align="right"><strong>收货人信息：</strong></td>
				  <td>
					<div class="layui-input-inline"><?php echo htmlentities($order['sname']); ?> / <?php echo htmlentities($order['sphone']); ?> / <?php echo htmlentities($order['saddress']); ?></div>
				  </td>
				</tr>
				
				<tr>
				  <td width="150" align="right"><strong>降权截图：</strong></td>
				  <td>
					<a href="javascript:;" target=" _blank" style="height:100px;display:inline-block;" >
						<img src="<?php echo htmlentities($order['image']); ?>" width="100" id="feng" style="cursor:pointer;"  onclick="opens(this)" />
					<a>
				  </td>
				</tr>
				
				
				<tr>
				  <td width="150" align="right"><strong>内容：</strong></td>
				  <td>
					<div class="layui-input-inline">
						<textarea id="demo" style="display: none;" name="content"><?php echo html_dcode($order['content']); ?></textarea>
					</div>
				  </td>
				</tr>
				
				
				<tr>
				  <td align="right"></td>
				  <td>
					<div class="layui-input-inline">
					  <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
					</div>
				  </td>
				</tr>
			  </tbody>
			</table>
		</form>	
    </div>
  </div>
  
	<div id="akali" class="hide layui-layer-wrap" style="display: none;">
		<img src="" id=""/>
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
	
	layui.use('layedit', function(){
	  var layedit = layui.layedit;
	  
		layedit.set({
		  uploadImage: {
			url: "<?php echo url('upload/upload_layui'); ?>" //接口url
			,type: 'post' //默认post
		  }
		});
	  
	  layedit.build('demo'); //建立编辑器
	});
	
	function opens(obj)
	{
		layui.use(['jquery', 'layer','table','flow','form'], function(){
			var table = layui.table
			,$ = layui.$
			,layer = layui.layer
			
			var src = obj.src;
			$('#akali img').attr('src', src);
			
			// 获取图片的真实宽高
			$('<img/>').attr("src", $('#akali img').attr("src")).load(function() {

				var pic_real_width = this.width;   // Note: $(this).width() will not
				var pic_real_height = this.height; // work for in memory images.
				
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