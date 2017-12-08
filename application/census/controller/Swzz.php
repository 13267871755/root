<?php
namespace app\census\controller;
use think\Controller;
use think\Session;

/**
 * Class Swzz
 * @package app\census\controller
 * 神王主宰
 */
class Swzz extends Controller
{
    public function index()
    {
        session_start();
        $this->assign('session_id',session_id());
        return $this->fetch('index');
    }
}
