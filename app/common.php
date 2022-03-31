<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

// 过滤html函数
if(! function_exists('html_dcode'))
{
	function html_dcode($str)
	{
		return htmlspecialchars_decode($str);
	}
}

// 加密解密函数
if(! function_exists('encrypt'))
{
	function encrypt($string, $operation, $key = '')
	{ 
		$key=md5($key); 
		$key_length=strlen($key); 
		$string = $operation == 'D' ? base64_decode($string):substr(md5($string.$key), 0, 8).$string;
		$string_length=strlen($string); 
		$rndkey=$box=array(); 
		$result=''; 
		for($i=0;$i<=255;$i++){ 
			   $rndkey[$i]=ord($key[$i%$key_length]); 
			$box[$i]=$i; 
		} 
		for($j=$i=0;$i<256;$i++){ 
			$j=($j+$box[$i]+$rndkey[$i])%256; 
			$tmp=$box[$i]; 
			$box[$i]=$box[$j]; 
			$box[$j]=$tmp; 
		} 
		for($a=$j=$i=0;$i<$string_length;$i++){ 
			$a=($a+1)%256; 
			$j=($j+$box[$a])%256; 
			$tmp=$box[$a]; 
			$box[$a]=$box[$j]; 
			$box[$j]=$tmp; 
			$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256])); 
		} 
		if($operation=='D'){ 
			if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){ 
				return substr($result,8); 
			}else{ 
				return''; 
			} 
		}else{ 
			return str_replace('=','',base64_encode($result)); 
		} 
	}
	
}



/**
 * @var bool 页面缓存
 */
function akali_cache($data = '')
{
	// 基本参数
	$request 	= request();
	$module 	= $request -> module(); // 模块名
	$controller = $request -> controller(); // 控制器名
	$action 	= $request -> action(); // 方法名
	$param 		= $request -> param(); // 参数
	
	$cache_name = 'akali_cache';
	/* 
	[
		'module' => [
			'controller' => [
				'action' => [
					'key' => 'url',
					'key' => 'url',
					'key' => 'url',
					'key' => 'url',
					'key' => 'url',
				],
			],
		],
	]
	 */
	
	$key = url($module . '/' . $controller . '/' . $action, $param); //'模块/控制器/方法名/参数';
	
	if(! empty($data))
	{
		// 保存缓存
		$result = cache(md5($key), $data);
		
		// 读取管理缓存数组数据
		$gl = cache($cache_name);
		$gl[$module][$controller][$action][md5($key)] = $key;
		
		// 保存缓存名
		cache($cache_name, $gl);
		return $result;
	}
	
	// 取出页面缓存
	$cache = cache(md5($key));
	return $cache;
	
/* 	用法
	// 读取缓存
	if(empty($this -> data))
	{
		// 逻辑代码
		
		$this -> data = $this -> fetch();
		akali_cache($this -> data);
	}
	
	return $this -> data;
 */	
}

// 递归
function get_child($array, $pid = 0)
{
	$temp = [];
	foreach($array as $key => $value)
	{
		if($value['pid'] == $pid)
		{
			$value['child'] = get_child($array, $value['id']);
			$temp[] = $value;
		}
	}
	return $temp;
}


function get_ip()
{
	return $_SERVER['REMOTE_ADDR'];
}


function get_date($value)
{
	return date("Y-m-d H:i:s", $value);
}


function msg($msg, $url = '', $wait = 3, $code = 0)
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
		<?php switch ({$code}) {?>
		<?php case 0:?>
		<h1>:)</h1>
		<p class="success"><?php echo(strip_tags({$msg}));?></p>
		<?php break;?>
		<?php case 1:?>
		<h1>:(</h1>
		<p class="error"><?php echo(strip_tags({$msg}));?></p>
		<?php break;?>
		<?php } ?>
		<p class="detail"></p>
		<p class="jump">
			页面自动 <a id="href" href="<?php echo($url);?>">跳转</a> 等待时间： <b id="wait"><?php echo($wait);?></b>
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


// 接口获取单号
function jm_number($url, $arg)
{
	
	header('Content-type:text/html;charset=utf-8');
	$query_string = http_build_query($arg);
	$ch = curl_init($url.'?'.$query_string);
	curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_USERAGENT , 'QQ_Mobile_V5.5');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 60 );
	curl_setopt($ch, CURLOPT_TIMEOUT , 60);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	$response = curl_exec($ch);
	$httpcode = curl_getinfo($ch , CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($response === false) {
		var_dump(curl_error($ch));
	} elseif ($httpcode != 200) {
		var_dump($httpcode, '接口请求失败');
	} else {
		$ret = json_decode($response, true);
		return $ret;
	}
}


/**
 * 返回成功的api接口数据
 *
 * @param  notype    $data      返回的数据
 * @param  string    $smg       描述信息
 * @param  int       $status    程序状态码
 * @param  int       $code      http状态码
 * @return json                 api返回的json数据
 */
function success($data = [], int $status = 20000, int $code = 200, string $msg = '成功')
{
    // 组装数据
    if (is_string($data) && (int)($data) == 0) {
        $resultData = [
            'status' => $status,
            'msg'    => $data,
            'data'   => [],
        ];
    }else{
        $resultData = [
            'status' => $status,
            'msg'    => $msg,
            'data'   => $data,
        ];
    }
    // 返回数据
    // echo json($resultData, $code);exit;
    return json($resultData, $code);
}

/**
 * 返回失败的api接口数据
 *
 * @param  string    $smg       描述信息
 * @param  int       $status    程序状态码
 * @param  int       $code      http状态码
 * @return json                 api返回的json数据
 */
function fail(string $msg = '失败', int $status = 40000, int $code = 400)
{
    // 组装数据
    $resultData = [
        'status' => $status,
        'msg'    => $msg,
    ];
    // 返回数据
    // echo json_encode($resultData, $code);exit;
    return json($resultData, $code);
}

/**
 * layui的节点树数据
 *
 * @param  array    $array          数组
 * @param  int      $parent_id      父级id
 * @return array                    返回处理后的字符串
 */
function get_child_tree_data($data = [], $parent_id = 0)
{
    $tmp = '';
    foreach ($data as $value) {
        if ($value['pid'] == $parent_id) {
            $tmp .= "{";
            $tmp .= "label: '{$value['title']}', id: {$value['id']}, pid: {$parent_id},";
            $child = get_child_tree_data($data, $value['id']);
            if($child){
                $tmp .= 'children:[' . $child . ']';
            }
            
            $tmp .= "},";
        }
    }
    
    return $tmp;
}