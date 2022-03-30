<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// +----------------------------------------------------------------------
// | 缓存设置
// +----------------------------------------------------------------------

return [
    // 验证码字符集合
	'codeSet' => '0123456789',
	// 验证码字体大小
	'fontSize'    => 20,
	// 验证码位数
	'length'      => 4,
	// 关闭验证码杂点
	'useNoise'    => true, 
	// 验证码图片高度，设置为0为自动计算
	'imageH'    => 50, 
	// 验证码图片宽度，设置为0为自动计算
	'imageW'    => 140, 
	/* 
    // 验证码字符集合
	'codeSet' => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',
	// 验证码字体大小
	'fontSize'    => 100,
	// 验证码位数
	'length'      => 1,
	// 关闭验证码杂点
	'useNoise'    => true, 
	// 验证码图片高度，设置为0为自动计算
	'imageH'    => 160, 
	// 验证码图片高度，设置为0为自动计算
	'imageW'    => 450,  */
];