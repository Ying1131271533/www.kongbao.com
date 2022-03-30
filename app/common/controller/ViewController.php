<?php
/**
 * Created by PhpStorm.
 * Date: 2019/3/20 0020 * Time: 23:20
 * Author: AnQin <an-qin@qq.com>
 * Copyright (c) 2014-2019 AnQin All rights reserved.
 */
declare (strict_types=1);

namespace app\common\controller;

use an\response\Jump;
use think\App;
use think\Container;
use think\exception\HttpResponseException;
use think\exception\ValidateException;
use think\facade\View as _View;
use think\Request;
use think\Response;
use think\response\Redirect;
use think\Validate;
use Throwable;

abstract class ViewController {
    /**
     * Request实例
     * @var Request
     */
    protected $request;

    /**
     * 应用实例
     * @var App
     */
    protected $app;

    /**
     * 验证失败是否抛出异常
     * @var bool
     */
    protected $failException = false;

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
    private $jumpTpl = '';

    /**
     * 构造方法
     * @access public
     * @param App $app 应用对象
     */
    public function __construct(App $app) {
        $this->app = $app;
        $this->request = $this->app->request;
        $this->jumpTpl = $app->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'jump.html';
        // 控制器初始化
        $this->initialize();
        $this->registerMiddleware();
    }

    protected function initialize() { }

    private function registerMiddleware() {
        foreach ($this->middleware as $key => $val) {
            if (!is_int($key)) {
                if (isset($val['only']) && !in_array($this->request->action(), $val['only'])) {
                    continue;
                } elseif (isset($val['except']) && in_array($this->request->action(), $val['except'])) {
                    continue;
                } else {
                    $val = $key;
                }
            }

            $this->app->middleware->controller($val);
        }
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param mixed   $msg 提示信息
     * @param string  $url 跳转的URL地址
     * @param mixed   $data 返回的数据
     * @param integer $wait 跳转等待时间
     * @param array   $header 发送的Header信息
     * @return void
     */
    /* protected function success($msg = '', string $url = null, $data = '', int $wait = 3, array $header = []) {
        if (is_null($url) && isset($_SERVER["HTTP_REFERER"])) $url = $_SERVER["HTTP_REFERER"]; elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Container::pull('route')->buildUrl($url);
        }
		
        $result = [
            'code' => 1,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        // 把跳转模板的渲染下沉，这样在 response_send 行为里通过getData()获得的数据是一致性的格式
        if ('html' == strtolower($type)) $type = Jump::class;
        $response = Response::create($result, $type)->header($header)->options([
            'jump_template' => $this->jumpTpl
        ]);
		
        throw new HttpResponseException($response);
    } */

    /**
     * 获取当前的response 输出类型
     * @access protected
     * @return string
     */
    protected function getResponseType() {
        return Container::pull('request')->isJson() ? 'json' : 'html';
    }
	
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param mixed   $msg 提示信息
     * @param string  $url 跳转的URL地址
     * @param mixed   $data 返回的数据
     * @param integer $wait 跳转等待时间
     * @param array   $header 发送的Header信息
     * @return void
     */
    /* protected function error($msg = '', string $url = null, $data = '', int $wait = 3, array $header = []) {
        if (is_null($url)) $url = Container::pull('request')->isAjax() ? '' : 'javascript:history.back(-1);'; elseif ($url) {
            $url = (strpos($url, '://') || 0 === strpos($url, '/')) ? $url : Container::pull('route')->buildUrl($url);
        }

        $result = [
            'code' => 0,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
            'wait' => $wait,
        ];

        $type = $this->getResponseType();
        if ('html' == strtolower($type)) $type = Jump::class;

        $response = Response::create($result, $type)->header($header)->options([
            'jump_template' => $this->jumpTpl
        ]);

        throw new HttpResponseException($response);
    } */

    // 注册控制器中间件

    /**
     * 返回封装后的API数据到客户端
     * @access protected
     * @param mixed   $data 要返回的数据
     * @param integer $code 返回的code
     * @param mixed   $msg 提示信息
     * @param string  $type 返回数据格式
     * @param array   $header 发送的Header信息
     * @return void
     */
    protected function result($data, $code = 0, $msg = '', $type = '', array $header = []) {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'time' => time(),
            'data' => $data,
        ];

        $type = $type ?: $this->getResponseType();
        $response = Response::create($result, $type)->header($header);

        throw new HttpResponseException($response);
    }

    // 初始化

    /**
     * URL重定向
     * @access protected
     * @param string        $url 跳转的URL表达式
     * @param array|integer $params 其它URL参数
     * @param integer       $code http code
     * @param array         $with 隐式传参
     * @return void
     */
    protected function redirect($url, $params = [], $code = 302, $with = []) {
        /** @var Redirect $response */
        $response = Response::create($url, 'redirect');

        if (is_integer($params)) {
            $code = $params;
            $params = [];
        }

        $response->code($code)->params($params)->with($with);

        throw new HttpResponseException($response);
    }

    /**
     * 设置验证失败后是否抛出异常
     * @access protected
     * @param bool $fail 是否抛出异常
     * @return $this
     */
    protected function validateFailException(bool $fail = true) {
        $this->failException = $fail;

        return $this;
    }

    /**
     * 验证数据
     * @access protected
     * @param array        $data 数据
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array        $message 提示信息
     * @param bool         $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false) {
        /** @var Validate $v */
        if (is_array($validate)) {
            $v = new Validate();
            $v->rule($validate);
        } else {
            if (strpos($validate, '.')) {
                // 支持场景
                list($validate, $scene) = explode('.', $validate);
            }
            $class = $this->app->parseClass('validate', $validate);
            $v = new $class();
            if (!empty($scene)) {
                $v->scene($scene);
            }
        }


//        return $v->message($message)->batch($batch)->failException(true)->check($data);
        $v->message($message);

        // 是否批量验证
        if ($batch || $this->batchValidate) {
            $v->batch(true);
        }

        if (!$v->failException($this->failException)->check($data)) {
            return $v->getError();
        }

        return true;
    }

    protected function fetch(string $template = '') {
        try {
            return _View::fetch($template);
        } catch (Throwable$e) {
            return $e->getMessage();
        }
    }

    /**
     * 渲染内容输出
     * @access protected
     * @param string $content 模板内容
     * @return mixed
     */
    protected function display(string $content = '') {
        return _View::display($content);
    }

    /**
     * 模板变量赋值
     * @access protected
     * @param string|array $name 模板变量
     * @param mixed        $value 变量值
     * @return $this
     */
    protected function assign($name, $value = null) {
        _View::assign($name, $value);
        return $this;
    }

    protected function assignJson($name, $value = null) {
        _View::assign($name, json_encode($value, JSON_UNESCAPED_UNICODE));
        return $this;
    }

    /**
     * 视图过滤
     * @access protected
     * @param Callable $filter 过滤方法或闭包
     * @return $this
     */
    protected function filter(callable $filter) {
        _View::filter($filter);
        return $this;
    }

    /**
     * 初始化模板引擎
     * @access protected
     * @param array|string $engine 引擎参数
     * @return $this
     */
    protected function engine($engine) {
        _View::engine($engine);
        return $this;
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
			<link rel="stylesheet" type="text/css" href="/static/admin/css/wechat.css">
			<link rel="stylesheet" type="text/css" href="/static/admin/css/wechatCommon.css">
			<style>
				.ruiwen dd{
					margin-right:15px;
					margin-bottom:15px;
				}
				.ruiwen ad{
					margin-right:15px;
					margin-bottom:15px;
				}
				
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