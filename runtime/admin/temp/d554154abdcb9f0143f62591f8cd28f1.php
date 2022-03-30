<?php /*a:2:{s:52:"D:\Web\www.tp6.com\app\admin\view\article\index.html";i:1559719687;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
		  <div class="layui-card-body layui-col-space5">
			<div class="layui-input-inline">
				<a class="<?php echo $type=='' ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url(''); ?>">全部<a>
			</div>
			<?php foreach($typeList as $value): ?>
			<div class="layui-input-inline">
				<a class="<?php echo $type==$value['id'] ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['type' => $value['id']]); ?>"><?php echo htmlentities($value['name']); ?><a>
			</div>
			<?php endforeach; ?>
			<div class="layui-input-inline" style="float:right;">
				<a href="<?php echo url('article/add'); ?>" class="layui-btn layui-btn-danger">添加文章</a>
			</div>
		  </div>
		<table id="layui_user" lay-filter="user"></table>
	</div>
	
	<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script>
	
	<script type="text/html" id="statusTpl">
		{{# if(d.status == 1){ }}
		<span class="layui-btn layui-btn-sm layui-bg-green">已通过</span>
		{{# } else { }}
		<span class="layui-btn layui-btn-sm layui-bg-red">未通过</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="operationTpl">
		<button class="layui-btn layui-btn-sm" lay-event="edit"><i class="layui-icon">&#xe642;</i> 修改</button>
		<button class="layui-btn layui-btn-sm layui-bg-black" lay-event="del"><i class="layui-icon">&#xe640;</i> 删除</button>
	</script>
	
	<script>
	layui.use(['jquery', 'layer','table','flow','form'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		
		// 第一个实例
		table.render({
			elem: '#layui_user'
			,url: "<?php echo url('index_data', ['type' => $type]); ?>"//数据接口
			,page: true //开启分页
			,id: 'user' 
			,limit: 20
			,limits: [20, 100, 200, 500]
			,size: 'lg'
			,cols: [[ //表头
				{field: 'id', title: 'ID', width:100, sort: true, fixed: 'left'}
				,{field: 'type', title: '分类', width:150} 
				,{field: 'title', title: '标题', width:631} 
				,{field: 'admin_id', title: '管理员ID', width:100,} 
				,{field: 'popularity', title: '访问量', width: 180, sort: true}
				,{field: 'create_time', title: '添加时间', width: 200, sort: true}
				,{field: 'status', title: '审核状态', width: 100, templet: '#statusTpl'} 
				,{field: 'operation', title: '操作', width: 200, templet: '#operationTpl', fixed: 'right'}
			]]
		});
		
		//监听排序事件 
		table.on('sort(user)', function(obj){
			console.log(obj.field);
			console.log(obj.type);
			console.log(this);
			
			table.reload('user', {
				initSort: obj
				,where: {
					field: obj.field
					,order: obj.type
				}
			});
			
		});
		
		var $ = layui.$, active = {
			reload: function(){
				var idReload = $('#idReload');
				var usernameReload = $('#usernameReload');
				
				//执行重载
				table.reload('user', {
					where: {
						id:idReload.val(),
						username:usernameReload.val(),
					}
				});
			}
		};
		
		//点击事件
		$('.akali').on('click', function(){
			var type = $(this).data('type');
			active[type] ? active[type].call(this) : '';
		});
		
		
		//监听工具条
		table.on('tool(user)', function(obj){
			var data = obj.data; //获得当前行数据
			var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）

			if(layEvent === 'edit')
			{
				layer.open({
					type: 2,
					title: '文章修改',
					content: '<?php echo url("edit"); ?>?id=' + data.id,
					shadeClose: true,
					shade: [0.8, '#000000'],
					area: ['1000px', '600px'],
				});
			}else if(layEvent === 'del')
			{ 
				layer.confirm('确定要删除文章吗', function(index){
					window.location.href = "<?php echo url('del'); ?>?id=" + data.id;
					layer.close(index);
				});
			}
		
		});
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