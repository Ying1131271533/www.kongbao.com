<?php /*a:2:{s:46:"D:\Web\www.tp6.com\app\admin\view\kd\edit.html";i:1559181723;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1623055181;}*/ ?>
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
		<form action="" method="post" enctype="multipart/form-data" name="example">
			<table class="layui-table" lay-size="lg" lay-skin="line">
			  <thead>
				<tr>
				  <th colspan="2">快递修改</th>
				</tr> 
			  </thead>
			  <tbody>
				<tr>
						
				  <td width="150" align="right"><strong>快递名：</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="text" name="name" placeholder="<?php echo htmlentities($express['name']); ?>" value ="<?php echo htmlentities($express['name']); ?>">
					</div>
				  </td>
				</tr>
				<tr>
				  <td align="right"><strong>快递描述：</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="test" name="explain" placeholder="<?php echo htmlentities($express['explain']); ?>" value ="<?php echo htmlentities($express['explain']); ?>">
					</div>
				  </td>
				</tr>
				<tr>
				  <td align="right"><strong>快递log:</strong></td>
				  <td>
					<div class="layui-upload">
					  <button type="button" class="layui-btn" id="test1">上传图片</button>
					  <div class="layui-upload-list">
						<img src="<?php echo htmlentities($express['image']); ?>" class="layui-upload-img" id="demo1">
						<p id="demoText"></p>
						<input type="hidden" name="image" value="<?php echo htmlentities($express['image']); ?>">
					  </div>
					</div>
				  </td>
				</tr>

				<tr>
				  <td align="right"><strong>购买状态：</strong></td>
				  <td>
					<div class="layui-input-inline">
					
						<?php if($express['type'] == 1): ?>
						<div class="layui-input-inline">
							<input class="layui-input" type="radio" name="type"  value ="1" title="可以" checked />
							<input class="layui-input" type="radio" name="type"  value ="0" title="不可以" />
						</div>
						<?php else: ?>
						<input class="layui-input" type="radio" name="type"  value ="1" title="正常" />
						<input class="layui-input" type="radio" name="type"  value ="0" title="禁用" checked />
						<?php endif; ?>
						
					</div>
				  </td>
				</tr>

				<tr>
				  <td align="right"><strong>状态：</strong></td>
				  <td>
					<div class="layui-input-inline">
					
						<?php if($express['status'] == 1): ?>
						<input class="layui-input" type="radio" name="status"  value ="1" title="正常" checked />
						<input class="layui-input" type="radio" name="status"  value ="0" title="禁用" />
						<?php else: ?>
						<input class="layui-input" type="radio" name="status"  value ="1" title="正常" />
						<input class="layui-input" type="radio" name="status"  value ="0" title="禁用" checked />
						<?php endif; ?>
						
					</div>
				  </td>
				</tr>
				
				<tr>
				  <td align="right"><strong>下单类型：</strong></td>
				  <td>
					<div class="layui-input-inline">
						<input class="layui-input" type="radio" name="ms"  value ="1" title="单个" <?php echo $express['ms']==1 ? 'checked'  :  ''; ?> />
						<input class="layui-input" type="radio" name="ms"  value ="2" title="多个" <?php echo $express['ms']==2 ? 'checked'  :  ''; ?> />
						<input class="layui-input" type="radio" name="ms"  value ="3" title="都可以" <?php echo $express['ms']==3 ? 'checked'  :  ''; ?> />
					</div>
				  </td>
				</tr>
				<tr>
					<td align="right"><strong>接口标识：</strong></td>
					<td>
					<div class="layui-input-inline">
						<input class="layui-input" type="test" name="apitype" placeholder="<?php echo htmlentities($express['apitype']); ?>" value ="<?php echo htmlentities($express['apitype']); ?>" />
					</div>
					</td>
				</tr>
				<tr>
				  <td align="right"><strong>排序：</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="test" name="sort_order" placeholder="<?php echo htmlentities($express['sort_order']); ?>" value ="<?php echo htmlentities($express['sort_order']); ?>" />
					</div>
				  </td>
				</tr>

				<tr>
				  <td align="right"><strong>普通会员价格：</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="test" name="level1" placeholder="<?php echo htmlentities($express['level1']); ?>" value ="<?php echo htmlentities($express['level1']); ?>">
					</div>
				  </td>
				</tr>
				<tr>
				  <td align="right"><strong>黄金会员价格：</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="test" name="level2" placeholder="<?php echo htmlentities($express['level2']); ?>" value ="<?php echo htmlentities($express['level2']); ?>">
					</div>
				  </td>
				</tr>
				<tr>
				  <td align="right"><strong>铂金会员价格：</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="test" name="level3" placeholder="<?php echo htmlentities($express['level3']); ?>" value ="<?php echo htmlentities($express['level3']); ?>">
					</div>
				  </td>
				</tr>
				<tr>
				  <td align="right"><strong>钻石会员价格：</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="test" name="level4" placeholder="<?php echo htmlentities($express['level4']); ?>" value ="<?php echo htmlentities($express['level4']); ?>">
					</div>
				  </td>
				</tr>

				<tr>
				  <td align="right"><strong>成本价格:</strong></td>
				  <td>
					<div class="layui-input-inline">
					  <input class="layui-input" type="test" name="cost_price" placeholder="<?php echo htmlentities($express['cost_price']); ?>" value ="<?php echo htmlentities($express['cost_price']); ?>">
					</div>
				  </td>
				</tr>
				<input type="hidden" name="id" value ="<?php echo htmlentities($express['id']); ?>">
				
				<tr>
					
				  <td align="right"></td>
				  <td>
					<div class="layui-input-inline">
						<input type="submit"class="layui-btn" lay-submit lay-filter="formDemo" value="立即提交" >
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
	layui.use(['jquery', 'layer','table','flow','form','upload'], function(){
		var table = layui.table
		,$ = layui.$
		,layer = layui.layer
		,flow = layui.flow
		,form = layui.form
		,upload = layui.upload
		
		//监听提交
		form.on('submit(formdemo)', function(data){
			layer.msg(json.stringify(data.field));
			return false;
		});
		
		//普通图片上传
		var uploadInst = upload.render({
			elem: '#test1'
			,url: "<?php echo url('upload/upload_img'); ?>"
			,before: function(obj){
			  //预读本地文件示例，不支持ie8
			  obj.preview(function(index, file, result){
				$('#demo1').attr('src', result); //图片链接（base64）
			  });
			}
			,done: function(res){
			  //如果上传失败
			  if(res.code > 0){
				return layer.msg(res.msg, {icon:2});
			  }
			  //上传成功
			  $('input[name="image"]').val(res.image);
			  return layer.msg(res.msg, {icon:1});
			}
			,error: function(){
			  //演示失败状态，并实现重传
			  var demoText = $('#demoText');
			  demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
			  demoText.find('.demo-reload').on('click', function(){
				uploadInst.upload();
			  });
			}
		});
	});

  </script>

	
	<!-- 打开图片放大窗口 -->
	<div id="akali" class="hide layui-layer-wrap" style="display: none;">
		<img src="" id=""/>
	</div>
	<script>
		function opens(obj)
		{
			layui.use(['jquery', 'layer','table','flow','form'], function(){
				var table = layui.table
				,$ = layui.$
				,layer = layui.layer
				
				var src = obj.src;
				$('#akali img').attr('src', src);
				
				// 获取图片的真实宽高
				$('<img/>').attr("src", $('#akali img').attr("src")).load(function() {

					var pic_real_width = this.width;   // Note: $(this).width() will not
					var pic_real_height = this.height; // work for in memory images.
					
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