<?php /*a:2:{s:56:"D:\Web\www.tp6.com\app\admin\view\order\order_image.html";i:1562071444;s:50:"D:\Web\www.tp6.com\app\admin\view\layout\base.html";i:1623056665;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>底单上传</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="/static/admin/layuiadmin/layui/css/layui.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/layuiadmin/style/admin.css" />
	<link rel="stylesheet" type="text/css" href="/static/admin/css/style.css" />
	<script type="text/javascript" src="/static/admin/js/common.js"></script>
	
<style>
.img{
	margin-top:10px;
}
#demo2 img{
	width:80px;
	margin-left:5px;
}
</style>

</head>
<body>
	
	<div class="layui-upload">
	  <button type="button" class="layui-btn img" id="test2">图片上传</button> 
	  <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
		预览图：
		<div class="layui-upload-list" id="demo2"></div>
	 </blockquote>
	</div>
	<script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script> 
	<script>
		layui.use(['upload', 'layer', 'jquery'], function(){
		  var upload = layui.upload
		  ,$ = layui.$
		  ,layer = layui.layer
		
		//多图片上传
		var jinx = upload.render({
			elem: '#test2'
			,url: "<?php echo url('order_image'); ?>"
			,multiple: true
			,before: function(obj){
			  //预读本地文件示例，不支持ie8
			  obj.preview(function(index, file, result){
				$('#demo2').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img">')
			  });
			  
			}
			,done: function(res){
			  // 暂停3秒
			  // sleep(3000);
			  // 上传完毕
			  if(res.code != 0)
			  {
				return layer.msg(res.msg, {icon:2});
			  }
			  //return layer.msg('上传成功', {icon:1});
			}
		  });
		});
		
		function sleep(numberMillis)
		{    
			var now = new Date();    
			var exitTime = now.getTime() + numberMillis;   
			while (true) { 
			now = new Date();       
			if (now.getTime() > exitTime) 
				return;    
			} 
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

					var pic_real_width = this.width > 1280 ? 1280 : pic_real_width;   // Note: $(this).width() will not
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