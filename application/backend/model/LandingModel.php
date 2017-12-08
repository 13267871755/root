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

class LandingModel extends Model
{
   

   public function getLandingList($data)
    {
       $go['list'] =  Db::query('SELECT DISTINCT game_name FROM xxwd_set_landing');
    if (!empty($data['game_name'])) {
            $res  =  Db::name('set_landing')->where('game_name',$data['game_name'])->order('update_time DESC')->paginate(10,false,['query'=>request()->param()]);
            $go['game'] = $data['game_name'];
        }else{
            $res  =  Db::name('set_landing')->order('update_time DESC')->paginate(10,false,['query'=>request()->param()]);
            $go['game'] = '';
        }
        

        $go['page']  = $res->render();
        $datas = '';
        foreach ($res as $k => $v) {
            $url     = url('landing/update',['id'=>$v['id']]);
            $option  = '<a href="javascript:void(0)" onclick="delete_landing(' . $v['id'] . ')" class="btn btn-danger btn-sm" >删除</a> ';
            $update  = "<a href='{$url}'  class='btn btn-primary pull-left' >修改</a>";
            $go['datas'][] = [
                'id'            =>$v['id'],
                'game_name'     =>$v['game_name'],
                'origin_page'   =>$v['origin_page'],
                'new_page'      =>$v['new_page'],
                'username'      =>$v['username'],
                'update_time'   =>date('Y-m-d H:i:s', $v['update_time']),
                'option'        =>$option,
                'update'        =>$update
            ];
        }
        return $go;
    }
    
    /**新增落地页信息
     * @param $data
     */
   
    public function insertLanding($data)
    {
            if(count($data) != '4'){
                    echo"<script>alert('参数不能为空！!');history.go(-1);</script>";
                    exit;
            }
           $game = "SELECT gname FROM xxwd_game WHERE gid=".$data['gid'];
            $gameName = Db::query($game)[0];
            $data['username'] = session('username');

            $sersql = "SELECT id FROM xxwd_set_landing WHERE  origin_page= '".$data['url_s']."'";
            $result = Db::query($sersql);

            if (empty($result)) {
                $sql = "INSERT INTO xxwd_set_landing (game_name,origin_page,new_page,username,update_time) VALUES('".$gameName['gname']."','".$data['url_s']."','".$data['url_s1']."','".$data['username']."','".time()."')";
            }else{
                $sql = "UPDATE xxwd_set_landing SET game_name='".$gameName['gname']."',origin_page='".$data['url_s']."',new_page='".$data['url_s1']."',username='".$data['username']."',update_time='".time()."' WHERE id = ".$result[0]['id'];
            }
            
            $res = Db::execute($sql);
            return $res;
    }

    public function updateLanding($data)
    {
            $sql = "UPDATE xxwd_set_landing SET game_name='".$data['game_name']."',origin_page='".$data['origin_page']."',new_page='".$data['new_page']."',username='".$data['username']."',update_time='".time()."' WHERE id = ".$data['id'];
            $res = Db::execute($sql);
            return $res;
    }
}