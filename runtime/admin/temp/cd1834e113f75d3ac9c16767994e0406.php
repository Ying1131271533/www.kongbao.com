<?php /*a:2:{s:49:"D:\Web\www.tp6.com\app\admin\view\admin\node.html";i:1559123513;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
	<div class="layui-row layui-col-sm10 layui-col-md-offset0" style="margin-bottom:20px;">
		<div class="layui-col-md9"><a href="<?php echo url('admin/node_add'); ?>" class="layui-btn layui-btn-danger">添加节点</a></div>
	</div>
	<div class="layui-col-sm10 layui-col-md-offset1">
		<?php foreach($node as $value): ?>
		<div class="rbac">
			<div class="title">
				<strong><?php echo htmlentities($value['title']); ?> - <?php echo htmlentities($value['sort']); ?></strong>
				<a href="javascript:edit(<?php echo htmlentities($value['id']); ?>, 0);" class="layui-btn layui-btn-xs">编辑</a>
				<a href="javascript:del(<?php echo htmlentities($value['id']); ?>, <?php echo htmlentities($value['pid']); ?>)" class="layui-btn layui-btn-xs layui-bg-black">删除</a>
				<a href="<?php echo url('admin/node_add', ['pid' => $value['id']]); ?>" class="layui-btn layui-btn-xs layui-btn-normal">增加子节点</a>
			</div>
			<ul class="rabc-ul">
				<?php if(!(empty($value['child']) || (($value['child'] instanceof \think\Collection || $value['child'] instanceof \think\Paginator ) && $value['child']->isEmpty()))): foreach($value['child'] as $val): ?>
				<li>
					<?php echo htmlentities($val['title']); ?>-<?php echo htmlentities($val['sort']); ?> 
					<a href="javascript:edit(<?php echo htmlentities($val['id']); ?>, <?php echo htmlentities($value['id']); ?>);" class="layui-btn layui-btn-xs">编辑</a>
					<a href="javascript:del(<?php echo htmlentities($val['id']); ?>, <?php echo htmlentities($val['pid']); ?>)" class="layui-btn layui-btn-xs layui-bg-black">删除</a>
				</li>
				<?php endforeach; ?>
				<?php endif; ?>
			<ul>
		</div>
		<?php endforeach; ?>
	</div>
	
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
		
		//执行一个laypage实例
		laypage.render({
			elem: 'page' //注意，这里的 test1 是 ID，不用加 # 号
			,count: 50 //数据总数，从服务端得到
		});
		
		//监听提交
		form.on('submit(formdemo)', function(data){
			layer.msg(json.stringify(data.field));
			return false;
		});
	});
	
	function edit(id, pid)
	{
		//修改信息
		layer.open({
		  id:'1',
		  type: 2,
		  title: '节点ID:' + id,
		  shadeClose: true,
		  shade: [0.8, '#000000'],
		  area: ['800px', '600px'],
		  content: "<?php echo url('node_edit'); ?>?id=" + id + '&pid=' + pid,
		});
	}
	
	function del(id)
	{
		layer.confirm('确定要删除此节点吗', function(index){
			window.location.href = "<?php echo url('node_del'); ?>?id=" + id;
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