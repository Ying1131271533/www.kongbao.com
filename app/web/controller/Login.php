<?php
namespace app\web\controller;

use app\common\controller\ViewController;
use app\common\model\User;

class Login extends ViewController
{

    public function index()
    {
        if (session('?userid')) {
            return $this->redirect(url('home/index'));
        }

        if (request()->isPost()) {
            $data = [
                'username' => input('buy_name/s'),
                'password' => input('buy_pass/s'),
                'code'     => input('code/d'),
            ];

            if (captcha_check($data['code']) !== true) {
                return ['code' => 2, 'msg' => '验证码错误'];
            }

            try {
                $valiResult = $this->validate($data, 'User.login');
            } catch (\ValidateException $e) {
                return ['code' => 2, 'msg' => $valiResult];
            }

            //判断用户名是否存在
            $user = User::where('username', $data['username'])->find();
            if (empty($user)) {
                return ['code' => 2, 'msg' => '用户名不存在'];
            }

            //判断密码是否正确
            if ($user['password'] !== md5($data['password'])) {
                return ['code' => 2, 'msg' => '密码错误'];
            }

            // 是否被禁止登录
            if ($user['isvalid'] == 2) {
                return ['code' => 2, 'msg' => '用户已被冻结详情请联系客服'];
            }

            // 记录登录信息
            $user->login_counts    = (int) $user['login_counts'] + 1;
            $user->last_login_ip   = get_ip();
            $user->last_login_time = time();
            $result                = $user->save();
            if (empty($result)) {
                return ['code' => 2, 'msg' => '网络异常'];
            }

            session('userid', $user['id']);
            session('username', $user['username']);
            return ['code' => 3, 'msg' => '登录成功'];
        }

        return $this->fetch();
    }

    public function logout()
    {
        session('userid', null);
        session('username', null);
        session('user', null);

        if (session('?userid')) {
            session('userid', null);
            session('username', null);
            session('user', null);
        }

        return $this->redirect(url('login/index'));
    }
}
