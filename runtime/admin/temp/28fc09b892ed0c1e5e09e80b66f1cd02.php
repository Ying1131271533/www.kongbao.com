<?php /*a:1:{s:53:"D:\Web\www.kongbao.com\app\admin\view\home\index.html";i:1648730642;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layuiAdmin std - 通用后台管理模板系统（iframe标准版）</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" type="text/css" href="/static/admin/layuiadmin/layui/css/layui.css" />
  <link rel="stylesheet" type="text/css" href="/static/admin/layuiadmin/style/admin.css" />
  
  <script>
  /^http(s*):\/\//.test(location.href) || alert('请先部署到 localhost 下再访问');
  </script>
</head>
<body class="layui-layout-body">
  
  <div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
      <div class="layui-header">
        <!-- 头部区域 -->
        <ul class="layui-nav layui-layout-left">
          <li class="layui-nav-item layadmin-flexible" lay-unselect>
            <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
              <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="http://www.tp6.com/admin/" target="_blank" title="前台">
              <i class="layui-icon layui-icon-website"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;" layadmin-event="refresh" title="刷新">
              <i class="layui-icon layui-icon-refresh-3"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach" lay-action="template/search.html?keywords="> 
          </li>
        </ul>
        <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
          
          <li class="layui-nav-item" lay-unselect>
            <a lay-href="app/message/index.html" layadmin-event="message" lay-text="消息中心">
              <i class="layui-icon layui-icon-notice"></i>  
              
              <!-- 如果有新消息，则显示小圆点 -->
              <span class="layui-badge-dot"></span>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="theme">
              <i class="layui-icon layui-icon-theme"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="note">
              <i class="layui-icon layui-icon-note"></i>
            </a>
          </li>
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="fullscreen">
              <i class="layui-icon layui-icon-screen-full"></i>
            </a>
          </li>
          <li class="layui-nav-item" lay-unselect>
            <a href="javascript:;">
              <cite><?php echo session('admin.name'); ?></cite>
            </a>
            <dl class="layui-nav-child">
              <dd><a lay-href="set/user/info.html">基本资料</a></dd>
              <dd><a lay-href="set/user/password.html">修改密码</a></dd>
              <hr>
              <dd style="text-align: center;"><a href="<?php echo url('login/logout'); ?>">退出</a></dd>
            </dl>
          </li>
          
          <li class="layui-nav-item layui-hide-xs" lay-unselect>
            <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
          <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
            <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
          </li>
        </ul>
      </div>
      
      <!-- 侧边菜单 -->
      <div class="layui-side layui-side-menu">
        <div class="layui-side-scroll">
          <div class="layui-logo" lay-href="<?php echo url('info'); ?>">
            <span>51空包代理</span>
          </div>
          
          <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
			
			<?php foreach($node as $key => $value): ?>
			
            <li data-name="<?php echo htmlentities($value['name']); ?>" class="layui-nav-item layui-nav-itemed">
              <a href="javascript:;" lay-tips="<?php echo htmlentities($value['title']); ?>" lay-direction="2">
                <i class="layui-icon layui-icon-<?php echo htmlentities($value['icon']); ?>"></i>
                <cite><?php echo htmlentities($value['title']); ?></cite>
              </a>
              <dl class="layui-nav-child">
				
				<?php if(!(empty($value['child']) || (($value['child'] instanceof \think\Collection || $value['child'] instanceof \think\Paginator ) && $value['child']->isEmpty()))): if($value['show'] == '1'): foreach($value['child'] as $k => $val): if($val['show'] == '1'): ?>
                <dd data-name="<?php echo htmlentities($val['name']); ?>" <?php echo $key==0 && $k == 1 ? 'class="layui-this"'  :  ''; ?>>
					<a lay-href="<?php echo url($val['name']); ?>" ><?php echo htmlentities($val['title']); ?></a>
                </dd>
				<?php endif; ?>
				<?php endforeach; ?>
				<?php endif; ?>
				<?php endif; ?>
				
                </dd>
              </dl>
            </li>
			
			<?php endforeach; ?>
			
			
			<!-- 
            <li data-name="component" class="layui-nav-item">
              <a href="javascript:;" lay-tips="组件" lay-direction="3">
                <i class="layui-icon layui-icon-component"></i>
                <cite>组件</cite>
              </a>
              <dl class="layui-nav-child">
                <dd data-name="grid">
                  <a href="javascript:;">栅格</a>
                  <dl class="layui-nav-child">
                    <dd data-name="list"><a lay-href="component/grid/list.html">等比例列表排列</a></dd>
                    <dd data-name="mobile"><a lay-href="component/grid/mobile.html">按移动端排列</a></dd>
                    <dd data-name="mobile-pc"><a lay-href="component/grid/mobile-pc.html">移动桌面端组合</a></dd>
                    <dd data-name="all"><a lay-href="component/grid/all.html">全端复杂组合</a></dd>
                    <dd data-name="stack"><a lay-href="component/grid/stack.html">低于桌面堆叠排列</a></dd>
                    <dd data-name="speed-dial"><a lay-href="component/grid/speed-dial.html">九宫格</a></dd>
                  </dl>
                </dd>
				
                <dd data-name="button">
                  <a lay-href="component/button/index.html">按钮</a>
                </dd>
                
              </dl>
            </li>
			 -->
			
          </ul>
        </div>
      </div>

      <!-- 页面标签 -->
      <div class="layadmin-pagetabs" id="LAY_app_tabs">
        <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
        <div class="layui-icon layadmin-tabs-control layui-icon-down">
          <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
            <li class="layui-nav-item" lay-unselect>
              <a href="javascript:;"></a>
              <dl class="layui-nav-child layui-anim-fadein">
                <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
              </dl>
            </li>
          </ul>
        </div>
        <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
          <ul class="layui-tab-title" id="LAY_app_tabsheader">
            <li lay-id="home/console.html" lay-attr="home/console.html" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
          </ul>
        </div>
      </div>
      
      
      <!-- 主体内容 -->
      <div class="layui-body" id="LAY_app_body">
        <div class="layadmin-tabsbody-item layui-show">
          <iframe src="<?php echo url('home/info'); ?>" frameborder="0" class="layadmin-iframe"></iframe>
        </div>
      </div>
      
      <!-- 辅助元素，一般用于移动设备下遮罩 -->
      <div class="layadmin-body-shade" layadmin-event="shade"></div>
    </div>
  </div>
  
  <script type="text/javascript" src="/static/admin/layuiadmin/layui/layui.js"></script>}
  <script>
	  layui.config({
		base: '/static/admin/layuiadmin/' //静态资源所在路径
	  }).extend({
		index: 'lib/index' //主入口模块
	  }).use(['index'],function(){
		layui.$('#LAY-system-side-menu li dl dd').click(function(){
		//	layui.admin.events.refresh();
		//	var url = layui.$(this).attr('lay-href');
		//	alert(url);
		//	window.location.href = url;
			//var obj = layui.$(this);
			layui.admin.events.closeThisTabs();
			//layui.$(this).trigger('click');
		});
	  });
  </script>
  
  
  <!-- 百度统计 -->
  <script>
  /* var _hmt = _hmt || [];
  (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?d214947968792b839fd669a4decaaffc";
    var s = document.getElementsByTagName("script")[0]; 
    s.parentNode.insertBefore(hm, s);
  })();*/
  </script>
</body>
</html>


