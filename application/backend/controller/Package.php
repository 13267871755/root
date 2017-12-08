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

use  app\backend\model\PackageModel;
use  app\backend\model\GameModel;
use  \think\Request;
use  \think\Db;
use  \think\Exception;

class Package extends Base
{
    public function index()
    {
        
       $list = new PackageModel();
       $param = input('param.');
       $where = [];
       if($param){
            if (!empty($param['gid'])) {
                $where[] = " gid='{$param['gid']}' ";
            }
             if (!empty($param['username'])) {
                $where[] = " username='{$param['username']}' ";
            }
            if (!empty($param['products'])) {
                $where[] = " products='{$param['products']}' ";
            }
            if (!empty($param['media'])) {
                $where[] = " media='{$param['media']}' ";
            }
            $where = $where ? implode(' AND ', $where) : '';
       }
        $res = $list->getPackageList('*', $where, 'create_time DESC ');
        
        $page = $res->render();
        $datas = $list->foreachp($res);
       
        $this->assign('datas',$datas);
        $this->assign('page', $page);
        $this->assign('list',$list->gamelist());
        $this->assign('rester',$list->usernamelist());
        return $this->fetch('index');
    }

    // public function packageJson()
    // {
    //     if (request()->isAjax()) {
    //         $where = $datas = [];
    //         $param = input('param.');
    //         $result['draw'] = intval($param['draw']);
    //         $result['data'] = [];
    //         if (!empty($param['gid'])) {
    //             $where[] = " gid='{$param['gid']}' ";
    //         }
    //          if (!empty($param['username'])) {
    //             $where[] = " username='{$param['username']}' ";
    //         }
    //         if (!empty($param['products'])) {
    //             $where[] = " products='{$param['products']}' ";
    //         }
    //         if (!empty($param['media'])) {
    //             $where[] = " media='{$param['media']}' ";
    //         }

    //         $limit = "LIMIT {$param['start']},{$param['length']}";
    //         $where = $where ? "WHERE " . implode(' AND ', $where) : '';

    //         $package = new PackageModel();
    //         $res = $package->getPackageList('*', $where, ' ORDER BY create_time DESC ', $limit);

    //         if ($res) {
    //             foreach ($res as $k => $v) {
    //                 $url = url('package/update',['pid'=>$v['pid']]);
    //                 $option = '<a href="javascript:void(0)" onclick="delete_package(' . $v['pid'] . ')" class="btn btn-danger btn-sm" >删除</a> ';
    //                 $update = "<a href='{$url}'  class='btn btn-primary pull-left' >修改</a>";
    //                 $datas[] = [
    //                     $v['gid'],
    //                     $v['pname'],
    //                     $v['pnumber'],
    //                     'http://landing.shxingwan.com/census/'.$v['page_url'],
    //                     $v['url'],
    //                     $v['monitoring_url'],
    //                     $v['download_url'],
    //                     $v['products'],
    //                     $v['media'],
    //                     date('Y-m-d,H:i:s', $v['create_time']),
    //                     $v['username'],
    //                     $option,
    //                     $update
    //                 ];
    //             }
    //             $result = [
    //                 "data" => $datas, //过滤后
    //             ];
    //             $result = array_merge($result, Db::query("SELECT COUNT(1) as recordsTotal FROM xxwd_package")[0], Db::query("SELECT COUNT(1) as recordsFiltered FROM xxwd_package $where")[0]);
    //         }
    //         return json($result);
    //     }

    // }

    public function deleted()
    {
        if (request()->isAjax()) {
            $data = input('param.');
            if (!isset($data['pid'])) exit('非法参数');
            try {
                $res = Db::name('package')->where('pid',$data['pid'])->find();
                $rester = Db::name('user')->where('username',$res['username'])->find();
                if(session('groupid') <= $rester['groupid'] ){
                    Db::query("DELETE FROM xxwd_package WHERE pid={$data['pid']}");
                    return json($this->return_arr('删除成功', 1, url('package/index')));
                }
                
            } catch (Exception $e) {
                return json($this->return_arr('删除失败', 0));
            }
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
            $temp_arr['username'] = session('username');
            $user = new PackageModel();
            $res = $user->insertPackage($temp_arr);
            return json($this->return_arr($res['msg'], $res['flag'], url('package/index')));
        }
        $datas = ['今日头条','爱奇艺','UC','百度'];
        $this->assign('data',$datas);
        $this->assign('games', (new GameModel())->getGameList());
        return $this->fetch('add');
    }

    public function update(){
        if ($_POST){
            $data = Request::instance()->param('data');
            $temp_arr = parseParams($data);
            $user = new PackageModel();
            $res = $user->updatePackage($temp_arr);
            return json($this->return_arr($res['msg'], $res['flag'], url('package/index')));
        }
        
       $id = input('param.pid');
       $url = new PackageModel();
       $datas = $url->page($id);
        $data = Db::name('user')->where('username',$datas['username'])->find();  
        if(session('groupid') >= $data['groupid'] ){
           if(session('username') != $data['username']){
                echo"<script>alert('禁止进入!');history.go(-1);</script>"; 
            } 
        }
         $res = Db::name('game')->where('gid',$datas['gid'])->find();
        $data = ['今日头条','爱奇艺','UC','百度'];


        $this->assign('data',$data);
        $this->assign('res',$res);
        $this->assign('games', (new GameModel())->getGameList());
        $this->assign('datas',$datas);
        return $this->fetch('update');
    }

    public function addget(){
        $gid = $_GET['gid'];
        return $res = Db::name('game')->where('gid',$gid)->find();
    }
}