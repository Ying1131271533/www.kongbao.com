<?php /*a:2:{s:54:"D:\Web\www.tp6.com\app\admin\view\admin\role_auth.html";i:1559357920;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1624086330;}*/ ?>
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
	<form class="layui-form" action="" method="post">
		<div class="layui-col-sm12 layui-col-md-offset1">
			<?php foreach($node as $value): ?>
			<div class="rbac">
				<div class="title">
					<input type="checkbox" name="node[]" value="<?php echo htmlentities($value['id']); ?>" lay-skin="primary" title="<?php echo htmlentities($value['title']); ?>" lay-filter="node" <?php if(in_array(($value['id']), is_array($roleNode)?$roleNode:explode(',',$roleNode))): ?>checked<?php endif; ?>>
				</div>
				<ul class="rabc-ul">
					<?php if(!(empty($value['child']) || (($value['child'] instanceof \think\Collection || $value['child'] instanceof \think\Paginator ) && $value['child']->isEmpty()))): foreach($value['child'] as $val): ?>
					<li>
						<input type="checkbox" name="node[]" value="<?php echo htmlentities($val['id']); ?>" lay-skin="primary" title="<?php echo htmlentities($val['title']); ?>" lay-filter="nodes" <?php if(in_array(($val['id']), is_array($roleNode)?$roleNode:explode(',',$roleNode))): ?>checked<?php endif; ?>>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>
				<ul>
			</div>
			<?php endforeach; ?>
			<div class="layui-row layui-col-sm10 layui-col-md-offset0" style="margin-bottom:20px;">
				<div class="layui-col-md9">
					 <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
				</div>
			</div>
		</div>
	</form>
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
		
	
		form.on('checkbox(node)', function(data){
			console.log(data.elem); //得到checkbox原始DOM对象
			console.log(data.elem.checked); //开关是否开启，true或者false
			console.log(data.value); //开关value值，也可以通过data.elem.value得到
			console.log(data.othis); //得到美化后的DOM对象
			
			var check = data.elem.checked;
			$(data.elem).parents('.rbac').find('ul input').prop('checked', check);
			form.render();
			
		}); 
	
		form.on('checkbox(nodes)', function(data){
			console.log(data.elem); //得到checkbox原始DOM对象
			console.log(data.elem.checked); //开关是否开启，true或者false
			console.log(data.value); //开关value值，也可以通过data.elem.value得到
			console.log(data.othis); //得到美化后的DOM对象
			
			var length = $(data.elem).parents('ul').find('input[type="checkbox"]:checked').length;
			if(length < 1)
			{
				$(data.elem).parents('.rbac').find('.title input').prop('checked', false);
			}else
			{
				$(data.elem).parents('.rbac').find('.title input').prop('checked', true);
			}
			
			form.render();
		}); 
		
		//监听提交
		form.on('submit(formDemo)', function(data){
			layer.msg(json.stringify(data.field));
			return false;
		});
		
		/*
		form.render(); //更新全部
		form.render('checkbox'); //刷新select选择框渲染	
		form.render(null, 'test1'); //更新 lay-filter="test1" 所在容器内的全部表单状态
		form.render('checkbox', 'test2'); //更新 lay-filter="test2" 所在容器内的全部 select 状态
		
		$('.title .layui-form-checkbox').click(function(){
			alert('阿卡丽');
		});
		
		$('.rabc-ul .layui-form-checkbox').click(function(){
			alert('锐雯');
		});
		*/
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