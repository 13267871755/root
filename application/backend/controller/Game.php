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

use  app\backend\model\GameModel;
use  app\backend\model\PackageModel;
use \think\Request;
use \think\Db;

class Game extends Base
{
    public function index()
    {
        $list = new PackageModel();
        $this->assign('list',$list->gamelist());
        return $this->fetch('index');
    }

    public function gameJson()
    {
        if (request()->isAjax()) {

            $where = $datas = [];

            $param = input('param.');
            $result['draw'] = intval($param['draw']);
            $result['data'] = [];
            if (!empty($param['gid'])) {
                $where[] = " gid='{$param['gid']}' ";
            }

            $limit = "LIMIT {$param['start']},{$param['length']}";
            $where = $where ? "WHERE " . implode(' AND ', $where) : '';
            $census = new GameModel();
            $res = $census->getGameList('*', $where, ' ORDER BY update_time DESC', $limit);
            if ($res) {
                foreach($res as $k=>$v){
                    if(strlen($v['url']) > 90){
                        $v['url'] = substr($v['url'],0,40) .'............'.substr($v['url'],-40);
                    }
                    $url = url('game/update',['gid'=>$v['gid']]);
                    $option = '<a href="javascript:void(0)" onclick="delete_game(' . $v['gid'] . ')" class="btn btn-danger btn-sm" >删除</a> ';
                    $update = "<a href='{$url}'  class='btn btn-primary pull-left' >修改</a>";
                    $datas[] = [
                        $v['gname'],
                        $v['flag'],
                        $v['url'],
                        date('Y-m-d H:i:s',$v['create_time']),
                        $option,
                        $update
                    ];
                }
                $result = [
                    "data" => $datas, //过滤后
                ];
                $result = array_merge($result, Db::query("SELECT COUNT(1) as recordsTotal FROM xxwd_game")[0], Db::query("SELECT COUNT(1) as recordsFiltered FROM xxwd_game $where")[0]);
            }
            return json($result);
        }
    }

    /**
     * @return mixed|\think\response\Json
     * 新增用户
     */
    public function add()
    {
        if (request()->isAjax()) {
            $data = Request::instance()->param('data');
            $temp_arr = parseParams($data);
            $user = new GameModel();
            $res = $user->insertGame($temp_arr);
            return json($this->return_arr($res['msg'], $res['flag'], url('game/index')));
        }
        if(session('groupid') != 1){
            echo"<script>alert('禁止进入!');history.go(-1);</script>";
        }
        return $this->fetch('add');
    }

     public function deleted()
    {
        if (request()->isAjax()) {
            $data = input('param.');
            if (!isset($data['gid'])) exit('非法参数');
            try {
                if(session('groupid') == 1){
                    Db::query("DELETE FROM xxwd_game WHERE gid={$data['gid']}");
                    return json($this->return_arr('删除成功', 1, url('game/index'))); 
                }
            } catch (Exception $e) {
                return json($this->return_arr('删除失败', 0));
            }
        }
    }


    public function update(){
        if (request()->isAjax()) {
            $data = Request::instance()->param('data');
            $temp_arr = parseParams($data);
            $user = new GameModel();
            $res = $user->updateGame($temp_arr);
            return json($this->return_arr($res['msg'], $res['flag'], url('game/index')));
        }
        if(session('groupid') != 1){
            echo"<script>alert('禁止进入!');history.go(-1);</script>";
        }
       $id = input('param.gid');
        $up = Db::name('game')->where('gid',$id)->find();
        $this->assign('games', (new GameModel())->getGameList());
        $this->assign('data',$up);
        return $this->fetch('update');
    }
}