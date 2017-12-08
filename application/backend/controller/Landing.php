<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/15
 * Time: 19:51
 * 后台用户管理控制器
 * author:iamzcr@gmail.com
 */
namespace app\backend\controller;


use  \think\Request;
use  \think\Db;
use  \think\model\Collection;
use  \think\Exception;
use  app\backend\model\LandingModel;
use  app\backend\model\PackageModel;
use  app\backend\model\GameModel;

class Landing extends Base
{

    public function index()
    {   
        $data = input('param.');

        $rester = new LandingModel();
        $go = $rester->getLandingList($data);

        $this->assign('list',$go['list']);
        $this->assign('landing',$go['datas']);
        $this->assign('page', $go['page']);
        $this->assign('game',$go['game']);
        return $this->fetch('index');
    }


    public function add(){
        if (input('param.gid')) {
            $data = input('param.');
            $rester = new LandingModel();
            $res = $rester->insertLanding($data);
            if($res){            
                $this->redirect('landing/index');     
            } else {           
                $this->error('新增失败');       
            }

        }
        $this->assign('games', (new GameModel())->getGameList());
        return $this->fetch('add');
    }

    public function deleted()
    {
        if (request()->isAjax()) {
            $data = input('param.');
            if (!isset($data['id'])) exit('非法参数');
            try {
                Db::name('set_landing')->where('id',$data['id'])->delete();
                return json($this->return_arr('删除成功', 1, url('landing/index')));
            } catch (Exception $e) {
                return json($this->return_arr('删除失败', 0));
            }
        }
    }



    public function update(){
        if (input('param.game_name')) {
            $data = input('param.');
     
            $data['username'] = session('username');
            $sql = "UPDATE xxwd_set_landing SET game_name='".$data['game_name']."',origin_page='".$data['origin_page']."',new_page='".$data['new_page']."',username='".$data['username']."',update_time='".time()."' WHERE id = ".$data['id'];
 
            $res = Db::execute($sql);
            if($res){            
                $this->redirect('landing/index');     
            } else {           
                $this->error('修改失败');       
            }
            
        }
        $id = input('param.id');
        $up = Db::name('set_landing')->where('id',$id)->find();

        $datas[] = [
            'id'=> $up['id'],
            'game_name'=> $up['game_name'],
            'origin_page'=>$up['origin_page'],
            'new_page' =>$up['new_page']          
        ];
        $this->assign('datas',$datas);
        return $this->fetch('update');
    }
    public function addget(){
        $gid = $_POST['gid'];
        $res = Db::query("SELECT page_url FROM xxwd_package WHERE gid={$gid}");
        return $res;
    }
}
