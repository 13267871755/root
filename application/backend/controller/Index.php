<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/15
 * Time: 20:18
 * 后台管理默认控制器
 * author:iamzcr@gmail.com
 */
namespace app\backend\controller;

class Index extends Base
{
    public function index(){
        return $this->fetch('index');
    }
    public function welcome()
    {
        return $this->fetch('welcome');
    }
}