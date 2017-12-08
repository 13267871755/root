<?php
/**
 * Created by PhpStorm.
 * User: zhuchengru
 * Date: 2016/10/8 0008
 * Time: 下午 6:39
 * 用户模型
 */
namespace app\backend\model;

use think\Model;
use think\Db;

class ConstructModel extends Model
{
    public function handleData($data){
        $top    = ' <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
                        <title>'.$data['gameName'].'</title>
                        <meta name="viewport" content="width=720, user-scalable=no">
                        <link href="/static/census/css/swiper-3.css" rel="stylesheet" type="text/css">
                        <link href="/static/census/css/index.css" rel="stylesheet" type="text/css">
                    </head>
                    <style></style>
                    <body>
                    <div id="container">';
        $header = ' <section class="content">';
        $footer = ' </section>
                    </div>';
        if ($data['fixed']==1) {
            $header = ' <header>
                            <img src="'.$data['url'].'/'.$data['icon'].'">
                            <a href="javascript:void(0);"  onclick="Download()" class="down down0"></a>
                        </header>
                        <section class="content">
                            <div class="position">
                                <img src="'.$data['url'].'/'.$data['icon'].'" /> 
                            </div>';
        }elseif($data['fixed']==2) {
            $footer = '     <div class="position">
                                <img src="'.$data['url'].'/'.$data['icon'].'" />
                                <a  href="javascript:void(0);"  onclick="Download()"  class="down down3"></a>
                            </div>
                        </section>
                        <footer>
                            <img src="'.$data['url'].'/'.$data['icon'].'" />
                            <a href="javascript:void(0);"  onclick="Download()" class="down down0"></a>
                        </footer>
                    </div>';
        }
        $download = '<div class="position"  id="a">';
        for ($i=1; $i <= $data['a']; $i++) { 
            $download .= '<a href="javascript:void(0);"  onclick="Download()" class="down  down'.$i.'"></a>';
        }
        $download .= '</div>';
        $section = '';
        $carouselStr = '';
        foreach ($data['picture'] as $k => $v) {
            if ($data['gifNum'] == $k+1) {
                $section .='<!-- gif动图部分 -->
                            <div class="position" style="background:url('.$data['url'].'/'.$v.') no-repeat; background-size:720px ;">
                                <img src="'.$data['url'].'/'.$data['gif'][0].'" width="720px"  />
                            </div>';
            }elseif ($data['carouselNum'] == $k+1) {
                foreach ($data['carousel'] as $key => $val) {
                    $carouselStr .='<div class="swiper-slide" data-swiper-slide-index="'.$key.'">
                                        <img src="'.$data['url'].'/'.$val.'" />
                                    </div>';
                }
                $section .='<!-- 轮播部分 -->
                            <div class="background" style="padding-bottom:30px; background:url('.$data['url'].'/'.$v.') no-repeat;">
                                <div class="swiper-container swiper1 swiper-container-horizontal">
                                    <div class="swiper-wrapper" style="transform: translate3d(-2810px, 0px, 0px); transition-duration: 0ms;">
                                       '.$carouselStr.'                                      
                                    </div>
                                </div>
                            </div>';
            }else{
                $section .='<!-- 普通展示部分 -->
                            <div class="position">
                                <img src="'.$data['url'].'/'.$v.'"  width="720px" />
                            </div>';
            }
        }

        $bottom = ' <script src="/static/census/js/jquery-2.1.4.min.js" type="text/javascript"></script>
                    <script src="/static/census/js/swiper-3.js" type="text/javascript"></script>
                    <script type="text/javascript" src="/static/census/js/touchSwipe.js"></script>
                    <script type="text/javascript" src="/static/census/js/main.js"></script>
                    <script type="text/javascript">
                        var mySwiper = new Swiper(".swiper-container",{
                            loop: true,
                            autoplay: 3000,
                        })
                    </script>
                    <script src="/static/lib/mobile-detect.min.js"></script>
                    <script type="text/javascript">
                    window.onload = function () {
                        var pnumber = "<{$Request.param.pnumber}>";
                        var system_os = "";
                        var system_version = "";
                        var system_type = "";
                        var view_type = "";
                        var view_venv = "";
                        var user_cookie = "<{$session_id}>";
                        var device_type = navigator.userAgent;
                        var md = new MobileDetect(device_type);
                        if (md.mobile() == "iPad") {
                            view_type = "iPad";
                            system_os = "IOS";
                            system_version = "unknown";
                            system_type = "unknown";
                        } else if (md.os() == "iOS") {
                            view_type = "iPhone";
                            system_os = md.os();
                            system_version = md.version("iPhone");
                            system_type = "iPhone";
                        } else if (md.os() == "AndroidOS") {
                            view_type = "Android";
                            system_os = md.os();
                            system_version = md.version("Android");
                            var sys_dict = device_type.split(";");
                            system_type = sys_dict[2];
                        } else {
                            view_type = "PC";
                            system_os = "PC";
                            system_version = "unknown";
                            system_type = "unknown";
                        }
                        $.ajax({
                            type: "POST",
                            url: "<{:url(\'census/add\')}>",
                            data: {
                                pnumber: pnumber,
                                system_os: system_os,
                                system_version: system_version,
                                system_type: system_type,
                                view_type: view_type,
                                view_venv: view_venv,
                                user_cookie: user_cookie,
                            },
                            success: function (response) {
                                var json = jQuery.parseJSON(response)
                                console.log(json)
                            }
                        });
                    }
                    $(window).on("beforeunload", function () {
                        var user_cookie = "<{$session_id}>";
                        $.ajax({
                            type: "POST",
                            url: "<{:url(\'census/leave\')}>",
                            data: {
                                user_cookie: user_cookie,
                            },
                            success: function (response) {
                                var json = jQuery.parseJSON(response)
                                console.log(json)
                            }
                        });
                    });
                    function Download() {
                        var pacakge = "<{$Request.param.pnumber}>";
                        $.ajax({
                            type: "POST",
                            url: "<{:url(\'download/add\')}>",
                            data: {package: pacakge},
                            success: function (response) {
                                var json = jQuery.parseJSON(response)
                                if (json.status === "fail") {
                                    alert(json.msg);
                                    return false;
                                } else {
                                    window.location.href = json.url;
                                    return false;
                                }
                            }
                        });
                    }
                </script>
                ';
        $content = $top.$header.$download.$section.$footer.$bottom;
        return $content;
    }


    public function createController($controllerName){

        $controllerPath = ROOT_PATH."application/census/controller/".$controllerName.".php";
        $templet = '<?php
                    namespace app\census\controller;
                    use think\Controller;
                    use think\Session;
                    use app\census\model\GameModel;
                    use think\Db;

                    class '.$controllerName.' extends Controller
                    {
                        public function index(){
                            session_start();
                            $url  = substr($_SERVER["REQUEST_URI"],8);
                            $get  = input("param.");

                            $Game = new GameModel();
                            if(isset($get["id"])){
                               $landing = Db::name("package")->field("monitoring_url","download_url")->where("mark",$get["id"])->find();
                            }else{
                                $landing["monitoring_url"] = "";
                                $landing["download_url"] = "";
                            }
                            $data["monitoring_url"] = trim($landing["monitoring_url"]);
                            $data["download_url"] = trim($landing["download_url"]);
                            $res  = $Game->Landing($url);
                            $this->assign("data",$data);
                            $this->assign("session_id",session_id());
                            if (!empty($get["pnumber"]) && $res) {
                                $page = $res[0]["new_page"];
                                return $this->fetch("$page");
                            }

                            return $this->fetch("index");
                        }

                        public function rzdzz(){
                            session_start();
                            $url  = substr($_SERVER["REQUEST_URI"],8);
                            $get  = input("param.");

                            $Game = new GameModel();
                            if(isset($get["id"])){
                               $landing = Db::name("package")->field("monitoring_url","download_url")->where("mark",$get["id"])->find();
                            }else{
                                $landing["monitoring_url"] = "";
                                $landing["download_url"] = "";
                            }
                            $data["monitoring_url"] = trim($landing["monitoring_url"]);
                            $data["download_url"] = trim($landing["download_url"]);
                            $res  = $Game->Landing($url);
                            $this->assign("data",$data);
                            $this->assign("session_id",session_id());
                            if (!empty($get["pnumber"]) && $res) {
                                $page = $res[0]["new_page"];
                                return $this->fetch("$page");
                            }

                            return $this->fetch("rzdzz");
                        }
                        
                        public function srcs(){
                            session_start();
                            $url  = substr($_SERVER["REQUEST_URI"],8);
                            $get  = input("param.");

                            $Game = new GameModel();
                            if(isset($get["id"])){
                               $landing = Db::name("package")->field("monitoring_url","download_url")->where("mark",$get["id"])->find();
                            }else{
                                $landing["monitoring_url"] = "";
                                $landing["download_url"] = "";
                            }
                            $data["monitoring_url"] = trim($landing["monitoring_url"]);
                            $data["download_url"] = trim($landing["download_url"]);
                            $res  = $Game->Landing($url);
                            $this->assign("data",$data);
                            $this->assign("session_id",session_id());
                            if (!empty($get["pnumber"]) && $res) {
                                $page = $res[0]["new_page"];
                                return $this->fetch("$page");
                            }
                            return $this->fetch("srcs");
                        }

                        public function syqy(){
                            session_start();
                            $url  = substr($_SERVER["REQUEST_URI"],8);
                            $get  = input("param.");

                            $Game = new GameModel();
                            if(isset($get["id"])){
                               $landing = Db::name("package")->field("monitoring_url","download_url")->where("mark",$get["id"])->find();
                            }else{
                                $landing["monitoring_url"] = "";
                                $landing["download_url"] = "";
                            }
                            $data["monitoring_url"] = trim($landing["monitoring_url"]);
                            $data["download_url"] = trim($landing["download_url"]);
                            $res  = $Game->Landing($url);
                            $this->assign("data",$data);
                            $this->assign("session_id",session_id());
                            if (!empty($get["pnumber"]) && $res) {
                                $page = $res[0]["new_page"];
                                return $this->fetch("$page");
                            }
                            return $this->fetch("syqy");
                        }

                        public function yhdl(){
                            session_start();
                            $url  = substr($_SERVER["REQUEST_URI"],8);
                            $get  = input("param.");

                            $Game = new GameModel();
                            if(isset($get["id"])){
                               $landing = Db::name("package")->field("monitoring_url","download_url")->where("mark",$get["id"])->find();
                            }else{
                                $landing["monitoring_url"] = "";
                                $landing["download_url"] = "";
                            }
                            $data["monitoring_url"] = trim($landing["monitoring_url"]);
                            $data["download_url"] = trim($landing["download_url"]);
                            $res  = $Game->Landing($url);
                            $this->assign("data",$data);
                            $this->assign("session_id",session_id());
                            if (!empty($get["pnumber"]) && $res) {
                                $page = $res[0]["new_page"];
                                return $this->fetch("$page");
                            }
                            return $this->fetch("yhdl");
                        }
                    }';
        if (!file_exists($controllerPath)) {
            @fopen($controllerPath,"x+");
            
            file_put_contents($controllerPath, $templet);
            return true;
        }
        return false;

    }
    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 搭建模板
     */
    public function content($dir,$pic,$link){
        $origin_str = file_get_contents($dir);
        //修改前
        $before = ' <div id="container">
                        <section class="content ">
                            <div class="position2">
                            <img src="__STATIC__/census/yzh/yzh8/1.jpg" style="width:720px">
                            </div>
                            <div class="position2">
                                <img src="__STATIC__/census/yzh/yzh8/2.1.jpg" style="width:720px">
                                <a href="javascript:void(0);" onclick="Download()"  class="down down2"></a>
                            </div>
                            <div class="position2">
                                <img src="__STATIC__/census/yzh/yzh8/3.jpg" style="width:720px">
                            </div>
                            <div class="position2">
                                <img src="__STATIC__/census/yzh/yzh8/4.jpg" style="width:720px">
                            </div>
                            <div class="position2">
                                <img src="__STATIC__/census/yzh/yzh8/5.jpg" style="width:720px">
                            </div>
                            <div class="position2">
                                <img src="__STATIC__/census/yzh/yzh8/6.jpg" style="width:720px">
                                <a href="javascript:void(0);" onclick="Download()"  class=" down down3"></a>
                            </div>
                        </section>
                    </div>';



        //修改后
        $top = '<div id="container">
            <section class="content ">
            <div class="position2" id="x">';

        $foot = '
                </div>
                </section>
            </div>';
        $img = '';

            //修改后
        $top_a = '
        </div>
        <div class="position2" id="a">';
        $a = '';
        for($i = 1; $i <= $link; $i++){
            $a .= "<a href='javascript:void(0);' onclick='Download()'  class=' down down".$i."'></a>";
         }

         $posi = $top_a . $a .$foot;
            for($i = 0; $i < count($pic); $i++){
                $img .= "<img src='".$pic[$i]."' style='width:720px'>";
            }
        $after = $top . $img . $posi;
        $update_str = str_replace($before, $after, $origin_str);
        file_put_contents($dir, $update_str);
        return $top . $img . $foot;
    }

    public function css($dir_dir,$dir){
        $origin_str = file_get_contents($dir_dir);
        $link = '<link href="__STATIC__/census/yzh/yzh8/index.css" rel="stylesheet" type="text/css">';
        $link_after = "<link href='__STATIC__/census/".$dir[1].'/'.$dir[0]."/index.css' rel='stylesheet' type='text/css'>";
        $dir_str = str_replace($link, $link_after, $origin_str);
        file_put_contents($dir_dir, $dir_str);
     
    }
    public function title($dir,$gname){
        $origin_str = file_get_contents($dir);
        $title = "<title>影之魂</title>";
        $title_after = "<title>".$gname."</title>";
        $update_title = str_replace($title, $title_after, $origin_str);
        file_put_contents($dir, $update_title);
    }


    // 这是复制文件夹
    public function copy_dir($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    copy_dir($src . '/' . $file,$dst . '/' . $file);
                    continue;
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }









}