<?php /*a:2:{s:47:"D:\Web\www.tp6.com\app\admin\view\kd\index.html";i:1559717582;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
			<div class="layui-input-inline layui-col-space5">
				<input class="layui-input" type="text" name="order" value="" placeholder="快递名称" id="nameReload">
			</div>
			<div class="layui-input-inline" style="float:right;">
				<a href="<?php echo url('add'); ?>" class="layui-btn  layui-btn-danger akali" data-type="reload">添加快递<a>
			</div>
			<div class="layui-input-inline">
				<button class="layui-btn akali" data-type="reload">搜索<button>
			</div>
		</div>
		
		
		  <div class="layui-card-body layui-col-space5">
			<div class="layui-input-inline">
				<a class="<?php echo $ms=='' ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url(''); ?>">全部<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $ms==1 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['ms' => '1']); ?>">单个<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $ms==2 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['ms' => '2']); ?>">多个<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $ms==3 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['ms' => '3']); ?>">单个/多个<a>
			</div>
		  </div>
		
		
		<table id="layui_user" lay-filter="user"></table>
	</div>
	
	<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script>
	
	<script type="text/html" id="typeTpl">
		{{# if(d.type == 1){ }}
		<span class="layui-badge layui-bg-green">可以</span>
		{{# }else { }}
		<span class="layui-badge layui-bg-red">不可以</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="statusTpl">
		{{# if(d.status == 1){ }}
		<span class="layui-badge layui-bg-green">正常</span>
		{{# }else { }}
		<span class="layui-badge layui-bg-red">暂停</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="msTpl">
		{{# if(d.ms == 1){ }}
		单个
		{{# }else if(d.ms == 2){ }}
		多个
		{{# }else if(d.ms == 3){ }}
		单个 / 多个
		{{# }}}
	</script>
	
	<script type="text/html" id="editTpl">
		<button class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i> 修改</button>
		<button class="layui-btn layui-btn-xs layui-bg-black" lay-event="del"><i class="layui-icon">&#xe640;</i> 删除</button>
	</script>
	
	<script>
	layui.use(['jquery', 'layer','table','flow','form','laypage'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		,laypage = layui.laypage
		
		
		// 第一个实例
		table.render({
			elem: '#layui_user'
			,url: "<?php echo url('index', ['ms' => $ms]); ?>" //数据接口
			,page: true //开启分页
			,id: 'user' 
			,limit: 20
			,limits: [20, 100, 200, 500]
			,size: 'sm'
			,cols: [[ //表头
				{field: 'id', title: 'ID', width:100, sort: true, fixed: 'left'}
				,{field: 'name', title: '快递名称', width:200} 
				,{field: 'explain', title: '描述', width:375} 
				,{field: 'sort_order', title: '排序', width:80, sort: true}
				,{field: 'level1', title: '普通会员', width:80}
				,{field: 'level2', title: '黄金会员', width:80}
				,{field: 'level3', title: '铂金会员', width:80}
				,{field: 'level4', title: '钻石会员', width:80}
				,{field: 'cost_price', title: '成本价格', width: 100}
				,{field: 'type', title: '是否可购买', width: 90, templet: '#typeTpl'}
				,{field: 'status', title: '状态', width: 70, templet: '#statusTpl'}
				,{field: 'ms', title: '下单类型', width: 100, templet: '#msTpl'}
				,{field: 'apitype', title: '接口标识', width: 100, templet: '#apitypeTpl'}
				,{field: 'edit', title: '操作', width: 155, templet: '#editTpl', fixed: 'right'}
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
				var nameReload = $('#nameReload');
				
				//执行重载
				table.reload('user', {
					where: {
						name:nameReload.val(),
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
				// window.location.href = "<?php echo url('edit'); ?>?id=" + data.id;
				layer.open({
					type: 2,
					title: '快递修改',
					content: '<?php echo url("edit"); ?>?id=' + data.id,
					shadeClose: true,
					shade: [0.8, '#000000'],
					area: ['1000px', '600px'],
				});
			}else if(layEvent === 'del')
			{ 
				layer.confirm('确定要删除此快递吗', function(index){
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