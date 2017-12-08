<?php
namespace app\census\controller;
use think\Controller;
use think\Session;

/**
 * Class Ztsj
 * @package app\census\controller
 * 泽天神纪
 */
class Ztsj extends Controller
{
    public function index()
    {
        session_start();
        $this->assign('session_id',session_id());
        return $this->fetch('index');
    }
}
