<?php
namespace app\census\controller;
use think\Controller;
use think\Session;
use think\Db;

/**
 * Class Ztsj
 * @package app\census\controller
 * 猎魔神域
 */
class Yzhsx extends Controller
{
   public function index1()
    {
        session_start();
        
        $get = input('param.');
        $url = substr($_SERVER['REQUEST_URI'],8);
            
        
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
          
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        if(!empty($get['pnumber'])){
            if($get['pnumber'] == 'yzhsx1'){
                return $this->fetch('yzh3/index');
            }else if($get['pnumber'] == 'yzhsx2'){
                $this->assign('pnumber','2');
            }else if($get['pnumber'] == 'yzhsx3'){
                $this->assign('pnumber','3');
            }else if($get['pnumber'] == 'yzhsx4'){
                $this->assign('pnumber','4');
            }else if($get['pnumber'] == 'yzhsx9'){
                $this->assign('pnumber','9');
            }else if($get['pnumber'] == 'yzhsx12'){
               return $this->fetch('yzhsx/index4');
            }else{
                $this->assign('pnumber','k');
            }
        }else{
                $this->assign('pnumber','k');
        }
            
        return $this->fetch('index1');
    }

    public function index2()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        
        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
      
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        return $this->fetch('index2');
    }

    public function index3()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }

        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
      
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        return $this->fetch('index3');
    }

    public function index4()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }

        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
      
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        return $this->fetch('index4');
    }

    public function index5()
    {
        session_start();
        

        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
        

        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
         if(!empty($get['pnumber'])){
            if($get['pnumber'] == 'yzhsx5'){
                $this->assign('pnumber','5');
            }else if($get['pnumber'] == 'yzhsx6'){
                $this->assign('pnumber','6');
            }else if($get['pnumber'] == 'yzhsx7'){
                $this->assign('pnumber','7');
            }else if($get['pnumber'] == 'yzhsx8'){
                $this->assign('pnumber','8');
            }else{
                    $this->assign('pnumber','k');
            }
         }else{
                $this->assign('pnumber','k');
        }
        
        return $this->fetch('index5');
    }

    public function index6()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }

        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
      
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        return $this->fetch('index6');
    }

    public function index7()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }

        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
      
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        return $this->fetch('index7');
    }
    
    public function index8()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }

        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
      
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        return $this->fetch('index8');
    }

    public function index9()
    {
        session_start();
        $a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }

        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');
      
        if(isset($get['id'])){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$get['id'])->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);
        $this->assign('session_id',session_id());
        return $this->fetch('index9');
    }
}
