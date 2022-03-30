<?php /*a:2:{s:51:"D:\Web\www.tp6.com\app\admin\view\article\type.html";i:1559120656;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1616248811;}*/ ?>
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
	
</head>
<body>
	
	<div class="layui-fluid">
		<div class="layui-row layui-col-md-offset0" style="margin-bottom:20px;">
			<div class="layui-col-md9">
				<a href="<?php echo url('article/type_add'); ?>" class="layui-btn layui-btn-danger">添加分类</a>
			</div>
		</div>
		<form class="layui-form" action="" method="post">
			<table class="layui-table">
			  <thead>
				<tr>
				  <th>ID</th>
				  <th>分类名称</th>
				  <th>创建时间</th>
				  <th>操作</th>
				</tr>
			  </thead>
			  <tbody>
				<?php foreach($type as $value): ?>
				<tr>
				  <td><?php echo htmlentities($value['id']); ?></td>
				  <td><?php echo htmlentities($value['name']); ?></td>
				  <td><?php echo get_date($value['create_time']); ?></td>
				  <td>
					<a href="javascript:edit(<?php echo htmlentities($value['id']); ?>);" class="layui-btn">
					  <i class="layui-icon">&#xe642;</i> 修改
					</a>
					<a class="layui-btn layui-bg-black" href="javascript:del(<?php echo htmlentities($value['id']); ?>);">
					  <i class="layui-icon">&#xe640;</i> 删除
					</a>
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
		layer.open({
			type: 2,
			title: '分类修改',
			content: '<?php echo url("type_edit"); ?>?id=' + id,
			shadeClose: true,
			shade: [0.8, '#000000'],
			area: ['800px', '400px'],
		});
	}
	
	function del(id)
	{
		layer.confirm('确定要删除吗', function(index){
			window.location.href = "<?php echo url('type_del'); ?>?id=" + id;
			layer.close(index);
		});
	}
  </script>

<body>
</html>