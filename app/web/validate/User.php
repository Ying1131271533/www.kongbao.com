<?php
namespace app\web\validate;

use think\Validate;

class User extends Validate
{
    protected $regex = [
        'phone' => '/^[0-9_-]{5,18}$/',
        'qq'    => '/^\d{5,11}$/',
    ];

    protected $rule = [
        'username|用户名' => 'require|unique:user',
        'password'     => 'require|min:6',
        'email'        => 'require|email|unique:user',
        'phone'        => 'regex:phone',
        'qq'           => 'regex:qq',
        'passworda'    => 'require|min:6',
        'passwordb'    => 'require|min:6|confirm:passwordc',
    ];

    protected $message = [
        'username.require'  => '用户名不能为空',
        'username.unique'   => '名称已存在',
        'password.require'  => '密码不能为空',
        'password.min'      => '密码不能少于6位',
        'email.require'     => '邮箱不能为空',
        'email.email'       => '邮箱格式错误',
        'phone.regex'       => '手机格式错误',
        'qq.regex'          => 'qq格式错误',
        'vcode.require'     => '验证码不能为空',

        'passworda.require' => '原密码密码不能为空',
        'passworda.min'     => '原密码不能少于6位',
        'passwordb.require' => '密码不能为空',
        'passwordb.min'     => '密码不能少于6位',
        'passwordb.confirm' => '两次密码不一致',
        'passwordc.require' => '密码不能为空',
        'passwordc.min'     => '密码不能少于6位',
        'vcode.length'      => '验证码字数为4位',
    ];

    protected $scene = [
        'login'    => ['username', 'password', 'code'],
        'register' => ['username', 'password', 'code', 'email'],
        'info'     => ['phone', 'qq'],
        'pass'     => ['passworda', 'passwordb', 'passwordc'],
    ];
}
