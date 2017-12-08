<?php
namespace app\census\controller;
use think\Controller;
use think\Session;

/**
 * Class Ztsj
 * @package app\census\controller
 * 猎魔神域
 */
class Xzfc2 extends Controller
{
    public function index()
    {
        session_start();
        $this->assign('session_id',session_id());
        return $this->fetch('index');
    }
}
