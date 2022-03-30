<?php /*a:2:{s:49:"D:\Web\www.tp6.com\app\admin\view\user\index.html";i:1622878523;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
			<div class="layui-input-inline">
				<input class="layui-input" type="text" name="id" value="" placeholder="ID" id="idReload">
			</div>
			<div class="layui-input-inline">
				<input class="layui-input" type="emali" name="emali" value="" placeholder="邮箱" id="emailReload">
			</div>
			<div class="layui-input-inline">
				<input class="layui-input" type="text" name="username" value="" placeholder="用户名" id="nameReload">
			</div>
			<div class="layui-input-inline">
				<button class="layui-btn akali" data-type="reload">搜索<button>
			</div>
		</div>
		
		
		<table id="layui_user" lay-filter="user"></table>
	</div>
	
	<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script> 
 
	<script type="text/html" id="levelTpl">
		{{# if(d.level == 1){ }}
		<span>普通会员</span>
		{{# }else if(d.level == 2){ }}
			<span>黄金会员</span>
		{{# }else if(d.level == 3){ }}
			<span>铂金会员</span>
		{{# }else if(d.level == 4){ }}
			<span>钻石</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="nameTpl">
		{{# if(d.name){ }}
		{{ d.name }}
		{{# }else { }}
		——
		{{# }}}
	</script>
	
	<script type="text/html" id="alipayTpl">
		{{# if(d.alipay){ }}
		{{ d.alipay }}
		{{# }else { }}
		——
		{{# }}}
	</script>
	
	<script type="text/html" id="emailTpl">
		{{# if(d.email){ }}
		{{ d.email }}
		{{# }else { }}
		——
		{{# }}}
	</script>
	
	<script type="text/html" id="moneyTpl">
		{{# if(d.money > 0){ }}
		<span style="color:#009688">{{ d.money }}</span>
		{{# }else { }}
		<span style="color: rgb(204, 204, 204)">{{ d.money }}</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="useMoneyTpl">
		{{# if(d.expense_money > 0){ }}
		<span style="color:#009688">{{ d.expense_money }}</span>
		{{# }else { }}
		<span style="color: rgb(204, 204, 204)">{{ d.expense_money }}</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="InlMoneyTpl">
		{{# if(d.frost_money > 0){ }}
		<span style="color:#009688">{{ d.frost_money }}</span>
		{{# }else { }}
		<span style="color: rgb(204, 204, 204)">{{ d.frost_money }}</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="createTimeTpl">
		{{ d.create_time || '' }}
	</script>
	
	<script type="text/html" id="mingxiTpl">
		<a href="javascript:;" style="color:#01AAED" lay-event="mingxi">资金明细</a>
	</script>
	
	<script type="text/html" id="statusTpl">
		{{# if(d.isvalid == 1){ }}
		<span class="layui-btn layui-btn-xs layui-bg-green">正常</span>
		{{# }else{ }}
		<span class="layui-btn layui-btn-xs layui-bg-red">禁止</span>
		{{# }}}
	</script>
	

	
	<script type="text/html" id="editTpl">
		<button class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i> 修改</button>
	</script>
	
	<script>
	layui.use(['jquery', 'layer', 'table', 'flow', 'form'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		
		var id = 'id=' + "<?php echo htmlentities($id); ?>";
		
		// 第一个实例
		table.render({
			elem: '#layui_user'
			,url: "<?php echo url('index_data', ['id' => $id, 'email' => $email, 'username' => $username]); ?>" //数据接口
			,page: true //开启分页
			,id: 'user' 
			,limit: 20
			,limits: [20, 100, 200, 500]
			,size: 'sm'
			,cols: [[ //表头
				{field: 'id', title: 'ID', width:80, sort: true, fixed: 'left'}
				,{field: 'username', title: '用户名', width:141}
				,{field: 'recommend_id', title: '推荐人ID', width:80}
				,{field: 'level', title: '会员等级', width:100, sort: true, templet: '#levelTpl'} 
				,{field: 'name', title: '真实姓名', width: 80, templet: '#nameTpl'} 
				,{field: 'alipay', title: '支付宝', width: 200, templet: '#alipayTpl'}
				,{field: 'email', title: '邮箱', width: 162, templet: '#emailTpl'}
				,{field: 'money', title: '可用余额 ', width:100, sort: true, templet: '#moneyTpl'} 
				,{field: 'expense_money', title: '消费金额 ', width:100, sort: true, templet: '#useMoneyTpl'}
				,{field: 'frost_money', title: '冻结金额 ', width:100, sort: true, templet: '#InlMoneyTpl'}
				,{field: 'create_time', title: '注册时间 ', width:150, templet: '#createTimeTpl'}
				,{field: 'create_ip', title: '注册IP ', width:120}
				,{field: 'login_counts', title: '登录次数 ', width:100, sort: true}
				,{field: 'mingxi', title: '资金明细 ', width:80, templet: '#mingxiTpl', fixed: 'right'}
				,{field: 'status', title: '登录状态 ', width:80, templet: '#statusTpl', fixed: 'right'}
				//,{field: 'tui', title: '退款 ', width:130, templet: '#tuiTpl'}
				,{field: 'edit', title: '操作 ', width:90, templet: '#editTpl', fixed: 'right'}
			]]
		});
		
		
		
		var $ = layui.$, active = {
			reload: function(){
				var idReload = $('#idReload');
				var emailReload = $('#emailReload');
				var nameReload = $('#nameReload');
				
				//执行重载
				table.reload('user', {
					where: {
						id:idReload.val(),
						email:emailReload.val(),
						username:nameReload.val(),
					}
				});
			}
		};
		
		//点击事件
		$('.akali').on('click', function(){
			var type = $(this).data('type');
			active[type] ? active[type].call(this) : '';
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
		
		//监听工具条
		table.on('tool(user)', function(obj){
			var data = obj.data; //获得当前行数据
			var layEvent = obj.event; //获得 lay-event 对应的值（也可以是表头的 event 参数对应的值）
			
			if(layEvent === 'mingxi')
			{ 
				// window.location.href = "<?php echo url('mingxi/index'); ?>?uid=" + data.id;
				layer.open({
					type: 2,
					title: '资金明细',
					content: '<?php echo url("Mingxi/index"); ?>?uid=' + data.id,
					shadeClose: true,
					shade: [0.8, '#000000'],
					area: ['1200px', '600px'],
				});
				
			} else if(layEvent === 'tui')
			{
				$('form').submit();
			} else if(layEvent === 'edit')
			{
				// window.location.href = "<?php echo url('edit'); ?>?id=" + data.id;
				layer.open({
					type: 2,
					title: '会员修改',
					content: '<?php echo url("edit"); ?>?id=' + data.id,
					shadeClose: true,
					shade: [0.8, '#000000'],
					area: ['1000px', '600px'],
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