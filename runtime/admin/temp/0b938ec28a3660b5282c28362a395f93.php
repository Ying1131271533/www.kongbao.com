<?php /*a:2:{s:50:"D:\Web\www.tp6.com\app\admin\view\order\index.html";i:1623055750;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
	
<style>
.layui-table-view .layui-table[lay-size=sm] .layui-table-cell {
	height: 40px;
	line-height: 20px;
}
</style>

</head>
<body>
	
	<div class="layui-fluid">
		<div class="layui-form">
			<div class="layui-input-inline">
				<input class="layui-input" type="text" name="number" value="" placeholder="单号" id="numberReload">
			</div>
			<div class="layui-input-inline">
				<button class="layui-btn akali" data-type="reload">搜索<button>
			</div>
		</div>
		
		<div class="layui-card-body layui-col-space5">
			<div class="layui-input-inline">
				<a class="<?php echo $kd_id==0 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url(''); ?>">全部<a>
			</div>
			<?php foreach($kd as $value): ?>
			<div class="layui-input-inline">
				<a class="<?php echo $kd_id==$value['id'] ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['kd_id' => $value['id']]).$statusStr; ?>"><?php echo htmlentities($value['name']); ?><a>
			</div>
			<?php endforeach; ?>
		</div>
		
		<div class="layui-card-body layui-col-space5">
			<div class="layui-input-inline">
				<a class="<?php echo $status=='' ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('').$kdidStr; ?>">全部<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $status==1 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '1']).$kdidStr; ?>">未处理<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $status==2 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '2']).$kdidStr; ?>">已处理<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $status==3 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '3']).$kdidStr; ?>">已拒绝<a>
			</div>
			<div class="layui-input-inline">
				<a href="<?php echo url('order_image'); ?>" class="layui-btn layui-btn-sm" style="background-color:#5FB878">上传底单<a>
			</div>
		</div>
		
		<form class="layui-form" action="<?php echo url('export'); ?>" method="post" name="number" lay-filter="bag">
			<div class="layui-card-body layui-col-space5">
				<div class="layui-input-inline">
					<input type="checkbox" name="id" title="全选" lay-filter="bag" lay-skin="primary"> 
				</div>
				<div class="layui-input-inline">
					<button type="subimt" class="layui-btn layui-btn-sm" >导出底单<button>
				</div>
			</div>
			
			<table id="layui_user" lay-filter="user" ></table>
		</form>
	</div>
	
	<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script>
	
	
	<script type="text/html" id="editTpl">
		{{# if(d.status == 1){ }}
			<a href="/order/view/id/{{ d.id }}/status/2" class="layui-badge layui-bg-blue">
				<i class="layui-icon">&#xe62f;</i>上传底单
			</a>
            <a href="/order/view/id/{{ d.id }}/status/3" class="layui-badge layui-bg-green"><i class="layui-icon">&#x1006;</i>拒绝</a>
		{{# }else if(d.status == 2){ }}
			<a href="/order/view/id/{{ d.id }}/status/2" class="layui-badge layui-bg-green">
				<i class="layui-icon">&#xe615;</i>查看底单</a>
		{{# }else if(d.status == 3){ }}
		<a href="/order/view/id/{{ d.id }}/status/3" class="layui-btn layui-btn-xs layui-bg-blue">
			<i class="layui-icon">&#xe607;</i>拒绝原因
		</a>
		{{# }}}
	</script>
	
	<script type="text/html" id="statusTpl">
		{{# if(d.status == 1){ }}
			<span class="layui-badge layui-bg-red">未处理</span>
		{{# }else if(d.status == 2){ }}
			<span class="layui-badge layui-bg-green">已处理</span>
		{{# }else if(d.status == 3){ }}
			<span class="layui-badge layui-bg-black">已拒绝</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="imageTpl">
		<img src="{{ d.image }}" width="70" style="cursor:pointer;"  onclick="open_img(this)" />
	</script>
	
	<script type="text/html" id="faTpl">
		<p><font style="color:#CC0000;">{{ d.fname }}</font> / <font style="color:#009688;">{{ d.fphone }}</font></p>
		{{ d.faddress }} 
	</script>
	
	<script type="text/html" id="shouTpl">
		<p><font style="color:#CC0000;">{{ d.sname }}</font> / <font style="color:#009688;">{{ d.sphone }}</font></p>
		{{ d.saddress }}
	</script>
	
	<script type="text/html" id="goodsTpl">
		<p>{{ d.goods_name }}</p>
		<p>{{ d.kg }}kg</p>
	</script>
	
	<script type="text/html" id="numberTpl">
		<p>{{ d.kdname }}</p>
		<p><a href="/bag/index/number/{{ d.number }}" style="color:#009688">{{ d.number }}</a></p>
	</script>
	
	<script type="text/html" id="usernameTpl">
		<a href="javascript:;" lay-event="username" style="color:#01AAED;">{{ d.username }}</a>[{{ d.user_id }}]
	</script>
	
	<script type="text/html" id="idTpl">
	<input type="checkbox" name="ids[]" title="" value="{{ d.id }}" lay-filter="bags" lay-skin="primary"> {{ d.id }}
	</script>
	
	<script>
	layui.use(['jquery', 'layer','table','flow','form'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		
		
		// 第一个实例
		var ins1 = table.render({
			elem: '#layui_user'
			,url: "<?php echo url('index_data', ['kd_id' => $kd_id, 'status' => $status]); ?>" //数据接口
			,page: true //开启分页
			,id: 'user' 
			,limit: 20
			,limits: [20, 100, 200, 500]
			,size: 'sm'
			,cols: [[ //表头
				{field: 'id', title: 'ID', width:100, sort: true, fixed: 'left', templet: '#idTpl'}
				,{field: 'username', title: '会员名称/ID', width:159, templet: '#usernameTpl'}
				,{field: 'number', title: '快递公司/快递单号', width:150, templet: '#numberTpl'}
				,{field: 'goods', title: '物品名 / 重量', width:130, templet: '#goodsTpl'}
				,{field: 'shou', title: '收货人姓名 / 电话 / 地址', width:300, templet: '#shouTpl'}
				,{field: 'fa', title: '发货人姓名 / 电话 / 地址', width:300, templet: '#faTpl'}
				,{field: 'create_time', title: '提交时间', width:150, sort: true}
				,{field: 'image', title: '降权截图', width:100, templet: '#imageTpl'}
				,{field: 'status', title: '状态', width:90,  templet: '#statusTpl',fixed: 'right'}
				,{field: 'edit', title: '操作', width:180, templet: '#editTpl',fixed: 'right'}
			]]
		});
		
		// 复选框
		form.on('checkbox(bag)', function(data){
			console.log(data.elem); //得到checkbox原始DOM对象
			console.log(data.elem.checked); //开关是否开启，true或者false
			console.log(data.value); //开关value值，也可以通过data.elem.value得到
			console.log(data.othis); //得到美化后的DOM对象
			
			var status = data.elem.checked;
			$('input[name="ids[]"]').prop('checked', status);
			form.render();
			
		}); 
		
		form.on('checkbox(bags)', function(data){
			console.log(data.elem); //得到checkbox原始DOM对象
			console.log(data.elem.checked); //开关是否开启，true或者false
			console.log(data.value); //开关value值，也可以通过data.elem.value得到
			console.log(data.othis); //得到美化后的DOM对象
			
			var length = $('input[name="ids[]"]').not("input:checked").length;
			if(length < 1)
			{
				$('input[name="id"]').prop('checked', true);
			}else
			{
				$('input[name="id"]').prop('checked', false);
			}
			
			form.render();
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
				var numberReload = $('#numberReload');
				
				//执行重载
				table.reload('user', {
					where: {
						number:numberReload.val(),
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
			
			switch(obj.event)
			{
				case 'edit':
					layer.open({
						type: 2,
						title: '修改',
						content: '<?php echo url("edit"); ?>?id=' + data.id,
						shadeClose: true,
						shade: [0.8, '#000000'],
						area: ['800px', '600px'],
					});
				break;
				case 'tui':
					window.location.href = "<?php echo url('tui'); ?>?id=" + data.id + '&user_id=' + data.user_id;
				break;
				case 'username':
					window.location.href = "<?php echo url('user/index'); ?>?id=" + data.user_id;
				break;
			};
			
		});
		
		$(document).keydown(function (event) {
			if (event.keyCode == 13) {
			  $('.akali').triggerHandler('click');
			}
		});
		
	});
	
	
	// 导出文档
	function excel()
	{
		layui.use(['jquery', 'layer'], function(){
			var $ = layui.$
			,layer = layui.layer
			
			
			$('form[name="number"]').submit();
		});
	}
	
	
	// 退单
	function tuis()
	{
		layui.use(['jquery', 'layer'], function(){
			var $ = layui.$
			,layer = layui.layer
			
			
			$('form[name=number]').attr('action', '<?php echo url("tuis"); ?>');
			$('form[name="number"]').submit();
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