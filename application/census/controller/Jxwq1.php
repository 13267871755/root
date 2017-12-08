<?php
namespace app\census\controller;
use think\Controller;
use think\Session;
use app\census\model\GameModel;
use think\Db;

class Jxwq1 extends Controller
{   
    //剑侠问情落地页
    public function index()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }
        $url  = substr($_SERVER['REQUEST_URI'],8);
        $get  = input('param.');

        $Game = new GameModel();
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $res  = $Game->Landing($url);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        if (!empty($get['pnumber']) && $res) {
            $page = $res[0]['new_page'];
            return $this->fetch("$page");
        }

        return $this->fetch('index');
    }
    
    public function yjfx()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }
        $url  = substr($_SERVER['REQUEST_URI'],8);
        $get  = input('param.');

        $Game = new GameModel();
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $res  = $Game->Landing($url);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        if (!empty($get['pnumber']) && $res) {
            $page = $res[0]['new_page'];
            return $this->fetch("$page");
        }

        return $this->fetch('yjfx');
    }

    public function dpyh()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }
        $url  = substr($_SERVER['REQUEST_URI'],8);
        $get  = input('param.');

        $Game = new GameModel();
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $res  = $Game->Landing($url);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        if (!empty($get['pnumber']) && $res) {
            $page = $res[0]['new_page'];
            return $this->fetch("$page");
        }

        return $this->fetch('dpyh');
    }
}

