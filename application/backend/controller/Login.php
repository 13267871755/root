<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/9 0009
 * Time: 下午 6:17
 */
namespace app\backend\controller;

use think\Controller;
use think\Db;
use  app\backend\model\UserModel;

class Login extends Controller
{
    public function _initialize()
    {
        $this->view->engine->layout(false);
    }

    /**
     * @return mixed
     * 登录页面
     */
    public function index()
    {
        $this->view->engine->layout(false);
        return $this->fetch('index');
    }

    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * 登录操作
     */
    public function doLogin()
    {
        $username = input("param.username");
        $password = input("param.password");
        $userModel = new UserModel();
        $user = $userModel->getUser(['username', $username]);

        if (empty($user)) {
            return json($this->return_arr('管理员或密码错误'));
        }
        if (strtotime($user->expiration) < time()) {
            return json($this->return_arr('账号已过期'));
        }

        if (md5($password) != $user['password']) {
            return json($this->return_arr('管理员或密码错误'));
        }
        if (1 != $user['status']) {
            return json($this->return_arr('该账号被禁用'));
        }

        $type = Db::name('user')->where('username',$username)->find();
        session('username', $username);
        session('uid', $user['uid']);
        session('groupid', $type['groupid']);

        //更新管理员状态
        $param = [
            'loginnum' => $user['loginnum'] + 1,
            'last_login_ip' => request()->ip(),
            'last_login_time' => time()
        ];

        (new UserModel())->where(['uid' => $user['uid']])->update($param);

        return json($this->return_arr('登录成功', true, url('index/index')));
    }

    /**
     * 用户登出
     */
    public function logout()
    {
        session(null);
        $this->redirect('login/index');
    }

    /**
     * @param $msg
     * @param bool $flag
     * @param null $url
     * @return array
     * 封装返回json数据
     */
    public function return_arr($msg, $flag = false, $url = null)
    {
        $arr = ['status' => 0, 'msg' => $msg, 'url' => $url];
        if ($flag) {
            $arr['status'] = 1;
        }
        return $arr;
    }
}
