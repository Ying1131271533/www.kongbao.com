
/**
 * 改变状态
 *
 * @param  this
 * @return $
 */
function ajax_status(obj)
{
	layui.use(['jquery', 'layer'], function(){
		var layer = layui.layer
		,$ = layui.$
		
		var id = $(obj).attr("data-id");
		var url = $(obj).attr("data-url");
		
		$.get(url, {id: id, url: url}, function(data){
		
			if(data.code == 0)
			{
				if(data.value == 1){
					$(obj).removeClass("layui-btn-danger").attr("data-url", data.url).text("开启");
				}else{
					$(obj).addClass("layui-btn-danger").attr("data-url", data.url).text("关闭");
				}
			}else{
				return layer.alert(data.msg, {icon:2});
			}
			
		}, 'json');
		
	});
}