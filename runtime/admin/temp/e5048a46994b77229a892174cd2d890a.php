<?php /*a:2:{s:56:"D:\Web\www.tp6.com\app\admin\view\article\type_edit.html";i:1558677589;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1616248811;}*/ ?>
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
		<div class="layui-form">
			<form action="" method="post" name="example">
				<table class="layui-table" lay-size="lg" lay-skin="line">
				  <thead>
					<tr>
						<th colspan="2">分类修改</th>
					</tr>
				  </thead>
				  <tbody>
					<tr>
					  <td width="150" align="right"><strong>分类名称</strong></td>
					  <td>
						<div class="layui-input-inline">
						  <input class="layui-input" type="text" name="name" value="<?php echo htmlentities($type['name']); ?>" placeholder="分类名称">
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

<body>
</html>