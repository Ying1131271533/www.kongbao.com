<?php /*a:2:{s:54:"D:\Web\www.tp6.com\app\admin\view\admin\node_tree.html";i:1648630823;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
		<div id="jinx" class="demo-tree"></div>
	</div>
  </div>

  <script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script> 
  <script>
	layui.use(['jquery', 'layer', 'table', 'flow', 'form', 'tree'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		,tree = layui.tree
		,util = layui.util
		
		//监听提交
		form.on('submit(formdemo)', function(data){
			layer.msg(json.stringify(data.field));
			return false;
		});
		
		//模拟数据
		data = [
			<?php foreach($node as $value): ?>
			{
				label: "<?php echo htmlentities($value['sort']); ?> - <?php echo htmlentities($value['title']); ?>"
				,id: <?php echo htmlentities($value['id']); ?>
				,pid:<?php echo htmlentities($value['pid']); if(!(empty($value['child']) || (($value['child'] instanceof \think\Collection || $value['child'] instanceof \think\Paginator ) && $value['child']->isEmpty()))): ?>
				,children: [
					
					<?php foreach($value['child'] as $val): ?>
					
					{
						label: "<?php echo htmlentities($val['sort']); ?> - <?php echo htmlentities($val['title']); ?>"
						,id: <?php echo htmlentities($val['id']); ?>
						,pid:<?php echo htmlentities($val['pid']); ?>
					},
					
					<?php endforeach; ?>
				]
				<?php endif; ?>
			},
			<?php endforeach; ?>
		];
		

		var checkbox = [];
		<?php foreach($node as $value): if(!(empty($value['child']) || (($value['child'] instanceof \think\Collection || $value['child'] instanceof \think\Paginator ) && $value['child']->isEmpty()))): foreach($value['child'] as $val): ?>
			checkbox.push(<?php echo htmlentities($val['id']); ?>);
		<?php endforeach; ?>
		<?php endif; ?>
		<?php endforeach; ?>
		
		// 树形菜单
		tree.render({
			elem: '#jinx'
			,data: data
			//,showCheckbox: true  //是否显示复选框
			,key: 'id'  //定义索引名称
			,checked: checkbox  //选中节点(依赖于 showCheckbox 以及 key 参数)。
			,spread: true  //展开节点(依赖于 key 参数)
			,accordion: true //是否开启手风琴模式
			,isJump: true //是否允许点击节点时弹出新窗口跳转
			,edit: ['add', 'update', 'del'] //操作节点的图标
			
			//节点被点击的回调
			,click: function(obj){
				//layer.msg('状态：'+ obj.state + '<br>节点数据：' + JSON.stringify(obj.data)); //获取当前选中的节点数据
				//layer.alert(JSON.stringify(obj));
			}
			
			//复选框被点击的回调
			,oncheck: function(obj){
				console.log(obj.data); //得到当前点击的节点数据
				console.log(obj.checked); //得到当前节点的展开状态：open、close、normal
				console.log(obj.elem); //得到当前节点元素
				console.log(obj.hasChild); //当前节点下是否有子节点
			}
			
			//节点增/删/改的回调
			,operate: function(obj){
				var type = obj.type; //得到操作类型：add、edit、del
				var data = obj.data; //得到当前节点的数据
				var elem = obj.elem; //得到当前节点元素
				
				//Ajax 操作
				
				//得到节点索引
				var id = data.id ? data.id : 0;
				var data_id = elem.attr('data-id');
				var pid = data_id ? data_id : 0;
				
				//增加节点
				if(type === 'add') {
					// 返回key值
					if(data.pid != 0) {
						alert('不能创建三级目录');
						window.location = "<?php echo url('admin/node_tree'); ?>";
					}

					var title = elem.find('.layui-tree-txt').html();
					add(pid, title);

				} else if(type === 'update') { //修改节点
					var title = elem.find('.layui-tree-txt').html();
					
					if(id == 0) {
						add(pid, title);
					}else {
						edit(id, title);
					}
					
				} else if(type === 'del') //删除节点
				{
					del(id, pid);
				};
			}
		});

		// 自动触发修改
		$('.layui-icon-edit').click(function(){
			//延时 触发失去焦点事件.
			setTimeout(function () { $('input').trigger("blur"); }, 100);
		});

	});
	
	
	function add(pid)
	{
		//修改信息
		layer.open({
			id:'1',
			type: 2,
			title: '添加节点',
			shadeClose: true,
			shade: [0.8, '#000000'],
			area: ['800px', '600px'],
			content: "<?php echo url('node_add'); ?>?pid=" + pid,
		});
	}
	
	
	function edit(id, title)
	{
		//修改信息
		layer.open({
			id:'1',
			type: 2,
			title: '节点ID:' + id,
			shadeClose: true,
			shade: [0.8, '#000000'],
			area: ['800px', '600px'],
			content: "<?php echo url('node_edit'); ?>?id=" + id + '&title=' + title,
		});
	}
	
	function del(id, pid)
	{
		if(!id) return false;
		
		layui.use(['jquery', 'layer'], function(){
			var layer = layui.layer
			,$ = layui.$
			
			$.post("<?php echo url('node_del_ajax'); ?>", {id:id, pid:pid}, function(data){
				if(data.status != 20000) {
					alert(data.msg);
					window.location = "<?php echo url('admin/node_tree'); ?>";
				}
				layer.msg('删除成功', {icon:1, time:600});
			}, 'json'); 
			
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