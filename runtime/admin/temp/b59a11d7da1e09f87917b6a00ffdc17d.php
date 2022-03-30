<?php /*a:2:{s:48:"D:\Web\www.tp6.com\app\admin\view\pay\index.html";i:1560409589;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
				<div class="layui-input-inline  layui-col-space5">
					<input class="layui-input" type="text" name="user_id" value="" placeholder="会员ID" id="uidReload">
				</div>
				<div class="layui-input-inline">
					<input class="layui-input" type="text" name="username" value="" placeholder="会员名称" id="usernameReload">
				</div>
				<div class="layui-input-inline">
					<input class="layui-input" type="text" name="order" value="" placeholder="订单号" id="orderReload">
				</div>
				<div class="layui-input-inline">
					<button class="layui-btn akali" data-type="reload">搜索<button>
				</div>
			</div>
			<div class="layui-card-body layui-col-space5">
				<div class="layui-input-inline">
					<a class="<?php echo $status=='' ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url(''); ?>">全部<a>
				</div>
				<div class="layui-input-inline">
					<a class="<?php echo $status==1 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '1']); ?>">待审核<a>
				</div>
				<div class="layui-input-inline">
					<a class="<?php echo $status==2 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '2']); ?>">充值成功<a>
				</div>
				<div class="layui-input-inline">
					<a class="<?php echo $status==3 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '3']); ?>">充值失败<a>
				</div>
			</div>
		<table id="layui_user" lay-filter="user"></table>

	</div>
	
	
	<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script>
	<script type="text/html" id="statusTpl">
		{{# if(d.status == 1){ }}
			<span class="layui-badge">待审核</span>
		{{# }else if(d.status == 2){ }}
			<span class="layui-badge layui-bg-green">已经确认</span>
		{{# }else if(d.status == 3){ }}
			<span class="layui-badge layui-bg-black">充值失败</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="checkTpl">
		{{# if(d.check_time){ }}
		{{ d.check_time }}
		{{# }else { }}
		——
		{{# }}}
	</script>

	<script type="text/html" id="msgTpl">
		{{# if(d.msg){ }}
		{{ d.msg }}
		{{# }else { }}
		——
		{{# }}}
	</script>
	
	<script type="text/html" id="editTpl">
		{{# if(d.status == 1){ }}
		<a class="layui-btn layui-btn-xs" onclick="edit({{ d.id }},2)">审核通过</a>
		<button class="layui-btn layui-btn-xs layui-bg-black" lay-event="edit">不通过</button>
		
		{{# }else { }}
		——
		{{# }}}
	</script>
	
	<script type="text/html" id="moneyTpl">
		<span style="color:#009688">{{ d.money }}</span>
	</script>
	
	<script type="text/html" id="usernameTpl">
		<a href="javascript:;" lay-event="username" style="color:#01AAED;">{{ d.username }}</a>[{{ d.user_id }}]
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
			,url: "<?php echo url('index_data', ['user_id' => $user_id, 'username' => $username, 'number' => $number, 'status' => $status]); ?>" //数据接口
			,page: true //开启分页
			,id: 'user' 
			,limit: 20
			,limits: [20, 100, 200, 500]
			,size: 'sm'
			,cols: [[ //表头
				{field: 'id', title: 'ID', width:150, sort: true, fixed: 'left'}
				,{field: 'username', title: '用户名[会员ID]',  templet: '#usernameTpl'} 
				,{field: 'order', title: '订单编号'} 
				,{field: 'money', title: '金额', templet: '#moneyTpl'}
				,{field: 'create_time', title: '创建时间',  sort: true} 
				,{field: 'ip', title: '操作IP'}
				,{field: 'msg', title: '失败原因',  templet: '#msgTpl'}
				,{field: 'check_time', title: '审核时间',  sort: true, templet: '#checkTpl'}
				,{field: 'status', title: '订单状态',  templet: '#statusTpl'}
				,{field: 'edit', title: '操作',  templet: '#editTpl',fixed: 'right'}
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
				var uidReload = $('#uidReload');
				var usernameReload = $('#usernameReload');
				var orderReload = $('#orderReload');
				
				//执行重载
				table.reload('user', {
					where: {
						user_id:uidReload.val(),
						username:usernameReload.val(),
						number:orderReload.val(),
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

			if(layEvent === 'username')
			{ 
				window.location.href = "<?php echo url('user/index'); ?>?id=" + data.user_id;
			}else if(layEvent === 'status')
			{
				
			}

			if(layEvent === 'edit')
			{
				// window.location.href = "<?php echo url('edit'); ?>?id=" + data.id;
				layer.open({
					type: 2,
					title: '失败原因',
					content: '<?php echo url("pay_edit"); ?>?id=' + data.id + '&status=' + 3,
					shadeClose: true,
					shade: [0.8, '#000000'],
					area: ['600px', '500px'],
				});
			}
		
		});
		
		//执行一个laypage实例
	/*	laypage.render({
			elem: 'jinx'
			,count: 20
			,layout: ['prev', 'page', 'next', 'limit', 'refresh', 'skip', 'count']
			,limit: 100
			,limits: [2, 50, 100, 200, 500]
			,jump: function(obj, first){
			console.log(obj.curr); //得到当前页，以便向服务端请求对应页的数据。
			console.log(obj.limit); //得到每页显示的条数
			console.log(obj.page); //得到每页显示的条数
			
			//首次不执行
			if(!first)
			{
				window.location = "<?php echo url(); ?>?" + 'curr=' + obj.curr + '&limit=' + obj.limit;
			}
		  }
		});
	*/
	
	});
	
	function edit(id, status)
	{
		window.location.href = "<?php echo url('edit'); ?>?id=" + id + '&status=' + status;
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