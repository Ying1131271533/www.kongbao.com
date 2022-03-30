<?php /*a:2:{s:48:"D:\Web\www.tp6.com\app\admin\view\bag\index.html";i:1568181026;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
				<input class="layui-input" type="text" name="username" value="" placeholder="ID" id="idReload">
			</div>
			<div class="layui-input-inline  layui-col-space5">
				<input class="layui-input" type="text" name="user_id" value="" placeholder="会员ID" id="uidReload">
			</div>
			<div class="layui-input-inline">
				<input class="layui-input" type="text" name="order" value="" placeholder="快递单号" id="numberReload">
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
				<a class="<?php echo $status==1 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '1']).$kdidStr; ?>">未导出<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $status==2 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '2']).$kdidStr; ?>">已导出<a>
			</div>
			<div class="layui-input-inline">
				<a class="<?php echo $status==3 ? 'layui-btn'  :  'layui-btn layui-btn-primary'; ?> layui-btn-sm" href="<?php echo url('', ['status' => '3']).$kdidStr; ?>">退单<a>
			</div>
		</div>
		
		<form class="layui-form" action="<?php echo url('export'); ?>" method="post" name="number" lay-filter="bag">
			<div class="layui-card-body layui-col-space5">
				<div class="layui-input-inline">
					<input type="checkbox" name="id" title="全选" lay-filter="bag" lay-skin="primary"> 
				</div>
				<?php if(!(empty($kd_id) || (($kd_id instanceof \think\Collection || $kd_id instanceof \think\Paginator ) && $kd_id->isEmpty()))): ?>
				<div class="layui-input-inline">
					<!-- <button class="layui-btn layui-btn-sm" onclick="excel()">导出订单<button> -->
					<button type="subimt" class="layui-btn layui-btn-sm" >导出订单<button>
				</div>
				<?php endif; if(!(empty($user_id) || (($user_id instanceof \think\Collection || $user_id instanceof \think\Paginator ) && $user_id->isEmpty()))): ?>
				<div class="layui-input-inline">
					<button type="subimt" class="layui-btn layui-btn-sm" onclick="tuis()">批量退单<button>
				</div>
				<?php endif; ?>
			</div>
			
			<table id="layui_user" lay-filter="user" ></table>
		</form>
	</div>
	
	
	<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script>
	
	
	<script type="text/html" id="editTpl">
		{{# if(d.status == 1 || d.status == 0){ }}
		<!-- <a class="layui-btn layui-btn-xs" lay-event="edit"><i class="layui-icon">&#xe642;</i>修改</a> -->
		<a class="layui-btn layui-btn-xs layui-bg-blue" lay-event="tui"><i class="layui-icon">&#xe640;</i>退单</a>
		{{# }else { }}
		——
		{{# }}}
	</script>
	
	<script type="text/html" id="statusTpl">
		{{# if(d.status == 0){ }}
			<span class="layui-badge layui-bg-red">未导出</span>
		{{# }else if(d.status == 1){ }}
			<span class="layui-badge layui-bg-green">已经导出</span>
		{{# }else if(d.status == 2){ }}
			<span class="layui-badge layui-bg-black">退单</span>
		{{# }}}
	</script>
	
	<script type="text/html" id="priceTpl">
		<p>{{ d.cost_price }} / {{ d.price }}</p>
	</script>
	
	<script type="text/html" id="faTpl">
		<p><font style="color:#CC0000;">{{ d.addresser }}</font> / <font style="color:#009688;">{{ d.phone }}</font></p>
		{{ d.province }} {{ d.city }} {{ d.county }} {{ d.address }} 
	</script>
	
	<script type="text/html" id="shouTpl">
		<p><font style="color:#CC0000;">{{ d.sname }}</font> / <font style="color:#009688;">{{ d.sphone }}</font></p>
		{{ d.sprovince }} {{ d.scity }} {{ d.scounty }} {{ d.saddress }}
	</script>
	
	<script type="text/html" id="goodsTpl">
		<p>{{ d.goods_name }} / {{ d.kg }}kg</p>
	</script>
	
	<script type="text/html" id="numberTpl">
		<p>{{ d.kd_name }}</p>
		<p style="color:#009688">{{ d.number }}</p>
	</script>
	
	<script type="text/html" id="usernameTpl">
		<a href="javascript:;" lay-event="username" style="color:#01AAED;">{{ d.username }}</a>
	</script>
	
	<script type="text/html" id="idTpl">
	{{# if(d.status == 3){ }}
	<input type="checkbox" name="ids[]" title="" value="{{ d.id }}" lay-filter="bags" lay-skin="primary" disabled> {{ d.id }}
	{{# }else { }}
	<input type="checkbox" name="ids[]" title="" value="{{ d.id }}" lay-filter="bags" lay-skin="primary"> {{ d.id }}
	{{# }}}
	<input type="hidden" name="uids[]" value="{{ d.user_id }}" />
	<input type="hidden" name="kd_id[]" value="{{ d.kd_id }}" />
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
			,url: "<?php echo url('index_data', ['id' => $id, 'kd_id' => $kd_id, 'user_id' => $user_id, 'number' => $number, 'status' => $status]); ?>" //数据接口
			,page: true //开启分页
			,id: 'user' 
			,limit: 20
			,limits: [20, 100, 200, 500]
			,size: 'sm'
			,cols: [[ //表头
				{field: 'id', title: 'ID', width:100, sort: true, fixed: 'left', templet: '#idTpl'}
				,{field: 'username', title: '会员名称', width:159, templet: '#usernameTpl'}
				,{field: 'number', title: '快递公司/快递单号', width:150, templet: '#numberTpl'}
				,{field: 'goods', title: '物品名 / 重量', width:130, templet: '#goodsTpl'}
				,{field: 'shou', title: '收货人姓名 / 电话 / 地址', width:300, templet: '#shouTpl'}
				,{field: 'fa', title: '发货人姓名 / 电话 / 地址', width:300, templet: '#faTpl'}
				,{field: 'time', title: '提交时间', width:150, sort: true}
				,{field: 'price', title: '成本 / 下单价', width:100, templet: '#priceTpl'}
				,{field: 'status', title: '状态', width:90,  templet: '#statusTpl',fixed: 'right'}
				,{field: 'edit', title: '操作', width:160, templet: '#editTpl',fixed: 'right'}
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
				var idReload = $('#idReload');
				var uidReload = $('#uidReload');
				var numberReload = $('#numberReload');
				
				var id = $('#idReload').val();
				var uid = $('#uidReload').val();
				var number = $('#numberReload').val();
				window.location.href = "<?php echo url(); ?>?id=" + id + '&user_id=' + uid + '&number=' + number;
	/*			//执行重载
				table.reload('user', {
					where: {
						id:idReload.val(),
						user_id:uidReload.val(),
						number:numberReload.val(),
					}
				});
	*/		
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
					window.location.href = "<?php echo url('tui'); ?>?id=" + data.id + '&user_id=' + data.user_id + '&number=' + data.number;
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