<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/9 0009
 * Time: 下午 6:17
 */
namespace app\backend\controller;


use app\backend\model\UserModel;
use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
        if(empty(session('username'))){
            $this->redirect(url('login/index'));
        }
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