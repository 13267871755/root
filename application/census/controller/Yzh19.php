<?php
namespace app\census\controller;
use think\Controller;
use think\Session;
use think\Db;
use app\census\model\GameModel;
/**
 * Class Ztsj
 * @package app\census\controller
 * 影之魂
 */
class Yzh19 extends Controller
{
   public function index()
    {
        session_start();
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

    public function rzdzz()
    {
        session_start();
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

        return $this->fetch('rzdzz');
    }
    
    public function srcs(){
        session_start();
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

        return $this->fetch('srcs');
    }

    public function syqy(){
       session_start();
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

        return $this->fetch('syqy');
    }

    public function yhdl(){
        session_start();
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

        return $this->fetch('yhdl');
    }
}
