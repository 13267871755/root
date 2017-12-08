<?php
namespace app\census\controller;
use think\Controller;
use think\db;
class Index extends Controller
{

	

    //永恒落地页
    public function index(){
    	$a = $_SERVER['HTTP_HOST'];
        if($a == 'xw.shuyuanwl.com'){
            $this->assign('host',true);
        }else{
            $this->assign('host',false);
        }
        
        session_start();
        $url = substr($_SERVER['REQUEST_URI'],8);
        $get = input('param.');

    
        $landing['monitoring_url'] = '';
        $landing['download_url'] = ''; 
       
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        $this->assign('data',$data);  
        
        $this->assign('session_id',session_id());

    	if (input('pnumber')) {
    		$data = input('pnumber');
    	}else{
    		$data = '';
    	}
    	
    	if ($data == '123') {
    		return $this->fetch('yzh2/srcs');
    	}
        return $this->fetch('index/yh');
    }
}
