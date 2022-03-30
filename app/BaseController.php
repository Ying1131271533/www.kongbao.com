<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2019 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
declare (strict_types = 1);

namespace app;

use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * 控制器基础类
 */
abstract class BaseController
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [];

    /**
     * 构造方法
     * @access public
     * @param  App  $app  应用对象
     */
    public function __construct(App $app)
    {
        $this->app     = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {}

    /**
     * 验证数据
     * @access protected
     * @param  array        $data     数据
     * @param  string|array $validate 验证器名或者验证规则数组
     * @param  array        $message  提示信息
     * @param  bool         $batch    是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                list($validate, $scene) = explode('.', $validate);
            }
            $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
            $v     = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }

        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        return $v->failException(true)->check($data);
    }
	
	protected function success($msg, $url = '', $wait = 3)
	{
		//如果 $url 为空，则给url赋值为来源页面
		if(empty($url))
		{
			$url = $_SERVER['HTTP_REFERER'];
		}
		
		//定界符
		$html = <<<AKALI
		
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
			<title>跳转提示</title>
			<style type="text/css">
				*{ padding: 0; margin: 0; }
				body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
				.system-message{ padding: 24px 48px; }
				.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
				.system-message .jump{ padding-top: 10px; }
				.system-message .jump a{ color: #333; }
				.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px; }
				.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
			</style>
		</head>
		<body>
		<div class="system-message">
			<h1>:)</h1>
			<p class="success">{$msg}</p>
			<p class="detail"></p>
			<p class="jump">
				页面自动 <a id="href" href="{$url}">跳转</a> 等待时间： <b id="wait">{$wait}</b>
			</p>
		</div>
		<script type="text/javascript">
			(function(){
				var wait = document.getElementById('wait'),
					href = document.getElementById('href').href;
				var interval = setInterval(function(){
					var time = --wait.innerHTML;
					if(time <= 0) {
						location.href = href;
						clearInterval(interval);
					};
				}, 1000);
			})();
		</script>
		</body>
		</html>

AKALI;
		die($html);
	}

	
	protected function error($msg, $url = '', $wait = 3)
	{
		//如果 $url 为空，则给url赋值为来源页面
		if(empty($url))
		{
			$url = $_SERVER['HTTP_REFERER'];
		}
		
		//定界符
		$html = <<<AKALI
		
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
			<title>跳转提示</title>
			<style type="text/css">
				*{ padding: 0; margin: 0; }
				body{ background: #fff; font-family: "Microsoft Yahei","Helvetica Neue",Helvetica,Arial,sans-serif; color: #333; font-size: 16px; }
				.system-message{ padding: 24px 48px; }
				.system-message h1{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
				.system-message .jump{ padding-top: 10px; }
				.system-message .jump a{ color: #333; }
				.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 36px; }
				.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display: none; }
			</style>
		</head>
		<body>
		<div class="system-message">
			<h1>:(</h1>
			<p class="success">{$msg}</p>
			<p class="detail"></p>
			<p class="jump">
				页面自动 <a id="href" href="{$url}">跳转</a> 等待时间： <b id="wait">{$wait}</b>
			</p>
		</div>
		<script type="text/javascript">
			(function(){
				var wait = document.getElementById('wait'),
					href = document.getElementById('href').href;
				var interval = setInterval(function(){
					var time = --wait.innerHTML;
					if(time <= 0) {
						location.href = href;
						clearInterval(interval);
					};
				}, 1000);
			})();
		</script>
		</body>
		</html>

AKALI;
		die($html);
	}

	
	protected function akali($msg, $url = '', $wait = 3)
	{
		//如果 $url 为空，则给url赋值为来源页面
		if(empty($url))
		{
			$url = $_SERVER['HTTP_REFERER'];
		}
		
		//定界符
		$html = <<<AKALI
		
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
			<title>跳转提示</title>
			<link rel="stylesheet" type="text/css" href="/static/admin/css/leaf.css">
			<style>
				.ruiwen dd{
					margin-right:15px;
					margin-bottom:15px;
				}
				.ruiwen ad{
					margin-right:15px;
					margin-bottom:15px;
				}
				.LAB_maincontW{padding:24px 30px 200px;background: #fff none;}
				.LAB_maincontW .myOperating{padding:0;}
			</style>
			
		</head>
		<body>
		<div class="main">
			<div class="weChat_main" style="padding-bottom: 0px;">
			
			  <!-- head-search end -->
			   <div class="weChat_content2" >
					<div class="LAB_maincont2 cf LAB_maincontW">
						<div class="noData cf">
							<dl>
								<dt><img src="\static\admin\images/noDataIco.png" alt=""></dt>
								<dd>
									<p>{$msg}</p>
									<p>
										页面自动 <a id="href" href="{$url}">跳转</a> 等待时间： <b id="wait">{$wait}</b>
									</p>
								</dd>
							</dl>
						</div>
					</div>
			   </div>
			</div>
		</div>
		
		<script type="text/javascript">
			(function(){
				var wait = document.getElementById('wait'),
					href = document.getElementById('href').href;
				var interval = setInterval(function(){
					var time = --wait.innerHTML;
					if(time <= 0) {
						location.href = href;
						clearInterval(interval);
					};
				}, 1000);
			})();
		</script>
		
		</body>
		</html>

AKALI;
		die($html);
	}
}
