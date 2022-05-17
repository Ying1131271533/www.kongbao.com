<?php /*a:2:{s:53:"D:\Web\www.kongbao.com\app\admin\view\admin\role.html";i:1559119961;s:54:"D:\Web\www.kongbao.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
		<div class="layui-row layui-col-md-offset0" style="margin-bottom:20px;">
			<div class="layui-col-md9">
				<a href="<?php echo url('admin/role_add'); ?>" class="layui-btn layui-btn-danger">添加角色</a>
			</div>
		</div>
		<form class="layui-form" action="" method="post">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>角色名称</th>
				  <th>描述</th>
				  <th>用户名列表</th>
				  <th>操作</th>
				</tr>
			  </thead>
			  <tbody>
				<?php foreach($roleList as $value): ?>
				<tr>
				  <td><?php echo htmlentities($value['id']); ?></td>
				  <td><?php echo htmlentities($value['name']); ?></td>
				  <td><?php echo htmlentities($value['explain']); ?></td>
				  <td>
					<?php if(!(empty($value['admin']) || (($value['admin'] instanceof \think\Collection || $value['admin'] instanceof \think\Paginator ) && $value['admin']->isEmpty()))): foreach($value['admin'] as $val): ?>
					<?php echo htmlentities($val); ?>、
					<?php endforeach; ?>
					<?php endif; ?>
				  </td>
				  <td>
					<a href="javascript:edit(<?php echo htmlentities($value['id']); ?>);" class="layui-btn">
					  <i class="layui-icon">&#xe642;</i> 修改
					</a>
					<a class="layui-btn layui-bg-black" href="javascript:del(<?php echo htmlentities($value['id']); ?>);">
					  <i class="layui-icon">&#xe640;</i> 删除
					</a>
					<a class="layui-btn layui-bg-blue" href="javascript:;" onclick="auth(<?php echo htmlentities($value['id']); ?>)">
					  <i class="layui-icon">&#xe66e;</i> 权限
					</a>
					<!-- <a class="layui-btn layui-bg-blue" href="<?php echo url('role_auth', ['id' => $value['id']]); ?>">
					  <i class="layui-icon">&#xe66e;</i> 权限
					</a> -->
				  </td>
				</tr>
				<?php endforeach; ?>
			  </tbody>
			</table>
		</form>
	</div>

  <script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script> 
  <script>
	layui.use(['jquery', 'layer', 'table', 'flow', 'form', 'laypage'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		,laypage = layui.laypage
		
		
		//监听提交
		form.on('submit(formdemo)', function(data){
			layer.msg(json.stringify(data.field));
			return false;
		});
		
		
	});

	function edit(id)
	{
		//修改信息
		layer.open({
		  id:'1',
		  type: 2,
		  title: '角色ID:' + id,
		  shadeClose: true,
		  shade: [0.8, '#000000'],
		  area: ['700px', '500px'],
		  content: "<?php echo url('role_edit'); ?>?id=" + id,
		});
	}
	
	function auth(id)
	{
		//修改信息
		layer.open({
		  id:'1',
		  type: 2,
		  title: '角色ID:' + id,
		  shadeClose: true,
		  shade: [0.8, '#000000'],
		  area: ['700px', '500px'],
		  content: "<?php echo url('admin/role_auth'); ?>?id=" + id,
		});
	}
	
	function del(id)
	{
		layer.confirm('确定要删除此角色吗', function(index){
			window.location.href = "<?php echo url('admin/role_del'); ?>?id=" + id;
			layer.close(index);
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