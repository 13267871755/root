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
use app\backend\model\GameModel;
use app\backend\model\ConstructModel;
use think\File;
use think\Validate;
use think\Db;
class Construct extends Base
{

    public function index(){
        if ($_POST) {
            // echo "<pre>";
            // var_dump($_POST);
            // var_dump($_FILES);exit;
            if (empty($_FILES['pic']['name'][0])||empty($_POST['url_s'])) {
                echo"<script>alert('参数不能为空！!');history.go(-1);</script>";
                exit;
            }

            $path = explode('/', $_POST["url_s"]);
            $dirPath = $path[0];
            
            $fullpath = ROOT_PATH."public/static/census/".$path[1]."/".$path[0];
            $path     = "/static/census/".$path[1]."/".$path[0];
            $fullpath = str_replace('\\', '/', $fullpath);

            if(!is_dir($fullpath)){
                mkdir($fullpath,0777,true);
            }

            $files = $_FILES['pic']['name'];
           
            $picture    = array();
            $counter    = 0 ;
            $gif        = array();
            $gifNum     = 0 ;
            $carousel   = array();
            $carouselNum= 0 ;
            $icon       = '';
            foreach ($files as $key => $value) {
                
                $path_parts = pathinfo($value);
                
                $ext = $path_parts['extension']; 

                $pic_path = $fullpath."/".$value;
                move_uploaded_file($_FILES['pic']['tmp_name'][$key], $pic_path);
                if (strlen($value) < 6) {
                   
                    array_push($picture, $value);

                }elseif (strlen($value)==7 && $ext=='gif') {
                    array_push($gif, $value);
                    $gifNum = $value{0};

                }elseif (strlen($value)==7 && $ext!='gif') {
                    array_push($carousel, $value);
                    $carouselNum = $value{0};
                    $counter++;
                }elseif (strlen($value)>=8) {
                    $icon = $value;
                }
                
            }
            
            $gameSql  = "SELECT gname FROM xxwd_game WHERE gid  = ".$_POST['gid'];
            $game     = Db::query($gameSql)[0];

            $data = array( 
                            'gameName'      => $game['gname'], 
                            'picture'       => $picture, 
                            'fixed'         => $_POST['fixed'],                       
                            'link'          => $_POST['url_s'],
                            'url'           => $path,
                            'a'             => $_POST['link'],
                            'counter'       => $counter,
                            'gif'           => $gif,
                            'gifNum'        => $gifNum,
                            'carousel'      => $carousel,
                            'carouselNum'   => $carouselNum,
                            'icon'          => $icon
                        );
            $construct = new ConstructModel();
            $create = $construct->createController(ucfirst($dirPath));
            if (!$create) {
                echo"<script>alert('落地页已经存在，需要修改请联系PHP！');history.go(-1);</script>";
                exit;
            }
            $html = $construct->handleData($data);
            $htmlPath = ROOT_PATH."application/census/view/".$dirPath;
            if(!is_dir($htmlPath)){
                mkdir($htmlPath,0777,true);
            }
            
            // var_dump($test);
            // var_dump($htmlPath);
            // exit;
            file_put_contents(ROOT_PATH."application/census/view/".$_POST['url_s'].".html",$html);
            $filePath = ROOT_PATH."application/census/view/".$_POST['url_s'].".html";
            $filePath = str_replace('\\', '/', $filePath);
            $this->assign('link',$_POST['url_s']);
            $this->assign('res',$html);
            $this->assign('path',$filePath);
            return $this->fetch('debug');
        }
        $this->assign('games', (new GameModel())->getGameList());
        return $this->fetch('add');
    }

    public function save(){

        $data = substr($_POST['treeCol'], 1);
        $arr  = explode(',', $data);
        $str  = "<style>";
        foreach ($arr as $k => $val) {
            $i = $k+1;
            $str .= ".down"."$i"."$val";
        }
        $str .="</style>";
        $content = file_get_contents($_POST['path']);
        $newContent = str_replace('<style></style>',$str, $content);
        $newContent .= "</body></html>";
        file_put_contents($_POST['path'], $newContent);
       
        echo $_POST['path'];
        
    }
 /*   public function pic(){
       
        $data = session('data');

        //反转图片
        $s = explode(',', $data['pictures']);
        $con = new ConstructModel();
        
        //创建目录文件
        $dir = explode('/', $data['link']);
        if (!file_exists("./static/census/".$dir[1].'/'.$dir[0]))
        {
            mkdir ("./static/census/".$dir[1].'/'.$dir[0],0777,true);
        }

        //复制文件
         if(!file_exists("./static/census/".$dir[1].'/'.$dir[0]."/"."index.css"))
       {
            $con->copy_dir("./static/census/vim/css","./static/census/".$dir[1].'/'.$dir[0]); 
        }

        if(!file_exists("../application/census/view/".$dir[1]."/".$dir[0].".html"))
       {
            $con->copy_dir("./static/census/vim/html","../application/census/view/".$dir[1]);
        }

        //文件重命名
        if(!file_exists("../application/census/view/".$dir[1]."/".$dir[0].".html"))
        {
            rename("../application/census/view/".$dir[1]."/"."index.html","../application/census/view/".$dir[1]."/".$dir[0].".html" );
        }
        
       
        // $files = "../application/census/view/".$dir[1]."/"."index.html";
        $files = "../application/census/view/".$dir[1]."/".$dir[0].".html";


        
        $v = $con->content($files,$s,$data['a']);
        $con->title($files,$data['game_name']);
        $con->css($files,$dir);

        
        $this->assign('res',$v);
         return $this->fetch('pic');
    }*/
    public function down(){
         $e = session('data');
        $dir = explode('/', $e['link']);
         $down = $_POST['treeCol'];
         $con = explode(',',$down);
         $d = '';
         for($i = 1; $i < count($con); $i++){
            $d .= '.down'.$i.$con[$i - 1];
         }
        $R = file_put_contents("./static/census/".$dir[1].'/'.$dir[0]."/"."index.css", $d, FILE_APPEND);
        if($R){
            echo true;
        }else{
            echo false;
        }
    }



}