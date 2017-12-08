<?php
namespace app\census\controller;
use think\Controller;

class Hxxl extends Controller
{
    public function index()
    {
        session_start();
        $this->assign('session_id',session_id());
        return $this->fetch('index');
    }
}
