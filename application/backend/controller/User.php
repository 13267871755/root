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

use  \think\Db;
use  app\backend\model\UserModel;
use app\backend\model\UserGroupModel;
use \think\Request;

class User extends Base
{
    public function index()
    {
        return $this->fetch('index');
    }

    public function userJson()
    {
        if (request()->isAjax()) {
            $user = new UserModel();
            $result = $user->getUserList();
            foreach ($result as $k => $v) {
                $url = url('user/edit',['id'=>$v['uid']]);

                $option = '<a href="javascript:void(0)" onclick="delete_user(' . $v['uid'] . ')" class="btn btn-danger btn-sm" >删除</a> ';
                $update = "<a href='{$url}'  class='btn btn-primary pull-left' >修改</a>";
                $datas[] = [
                    $v['username'],
                    $v['name'], 
                    $v['create_time'],
                    $v['last_login_time'],
                    $v['last_login_ip'], 
                    $v['expiration'], 
                    $v['status'],
                    $option,
                    $update
                ];
            }
            $where = '1=1';

            return json([
                'aaData' => $datas,
                'iTotalRecords' => $user->count(1),
                'iTotalDisplayRecords' => $user->where($where)->count(1),
            ]);
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
            $user = new UserModel();
            $res = $user->insertUser($temp_arr);
            return json($this->return_arr($res['msg'], $res['flag'], url('user/index')));
        }
        $data  = Db::query('SELECT groupid,name FROM  xxwd_user_group');

// var_dump($data);exit;
        $this->assign('expiration', date('Y-m-d', strtotime('+60days')));
        $this->assign('user_groups', (new UserGroupModel())->getUserGroupList('name,groupid'));

        return $this->fetch('add'); 
    } 

    /**
     * @return mixed|\think\response\Json
     * 编辑用户
     */
    public function edit()
    {
        if (request()->isAjax()) {
            $data = Request::instance()->param('data');
            $temp_arr = parseParams($data);
            foreach ($temp_arr as $k => $v) {
                if (empty($v)) {
                    return json($this->return_arr($k . '不能为空'));
                }
            }
            $id = $temp_arr['uid'];
            unset($temp_arr['uid']);
            if(strlen($temp_arr['password']) !== 32){
                $temp_arr['password'] = md5($temp_arr['password']);
            }
            $user = new UserModel();
            if ($user->update($temp_arr, ['uid' => $id])) {
                return json($this->return_arr('更新成功', true, url('user/index')));
            } else {
                return json($this->return_arr('更新失败'));
            }

        }
        $id = Request::instance()->param('id');
        $user = new UserModel();

        $data = $user->getUser(['uid', $id]);
        if(session('groupid') >= $data['groupid'] ){
            if(session('username') != $data['username']){
                echo"<script>alert('禁止进入!');history.go(-1);</script>"; 
            }
        }

        $this->assign('data', $data);
        $this->assign('user_groups', (new UserGroupModel())->getUserGroupList());
        return $this->fetch('edit');
    }

    /**
     * @return \think\response\Json
     * 删除用户
     */
    public function delete()
    {
        if (request()->isAjax()) {
            $id = Request::instance()->param('id');
             $user = new UserModel();
            $data = $user->getUser(['uid', $id]);
            if(session('groupid') < $data['groupid'] ){
                    if ($user->del($id)) {
                        return json($this->return_arr('删除成功', true, url('user/index')));
                    } else {
                        return json($this->return_arr('删除失败'));
                    } 
            }
        }
    }

    /**
     * @return \think\response\Json
     * 延长用户有效期
     */
    public function expiration()
    {
        if (request()->isAjax()) {
            $id = Request::instance()->param('id');
            $user = new  UserModel();
            $res = $user->getUser(['uid', $id]);
            if (!$res) {
                return json($this->return_arr('用户不存在'));
            }
            if ($user->update(['expiration' => ($res['expiration'] + 30 * 86400)], ['uid' => $res['uid']])) {
                return json($this->return_arr(date('Y-m-d', $res['expiration'] + 30 * 86400), true, url('user/index')));
            } else {
                return json($this->return_arr(date('Y-m-d', $res['expiration']), true, url('user/index')));
            }
        }
    }

    /**
     * @return \think\response\Json
     * 延长用户有效期
     */
    public function changeStatus()
    {
        if (request()->isAjax()) {
            $id = Request::instance()->param('id');
            $status = Request::instance()->param('status');
            $user = new  UserModel();
            $res = $user->getUser(['uid', $id]);
            if (!$res) {
                return json($this->return_arr('用户不存在'));
            }
            if ($user->update(['status' => $status], ['uid' => $res['uid']])) {
                return json($this->return_arr('更新成功', true, url('user/index')));
            } else {
                return json($this->return_arr('更新失败'));
            }
        }
    }

    /**
     * @return mixed|\think\response\Json
     * 修改个人密码
     */
    public function password()
    {
        if (request()->isAjax()) {
            $data = Request::instance()->param('data');
            $user = new  UserModel();
            $res = $user->getUser(['username', session('username')]);
            if (!$res) {
                return json($this->return_arr('用户不存在'));
            }
            $temp_arr = parseParams($data);
            $temp_arr['salt'] = UserModel::createSalt();
            $password = $temp_arr['password'];
            $temp_arr['password'] = UserModel::convertPassword($password, $temp_arr['salt']);

            if ($user->update($temp_arr, ['uid' => $res['uid']])) {
                return json($this->return_arr('更新成功', true, url('user/index')));
            } else {
                return json($this->return_arr('更新失败'));
            }
        }
        return $this->fetch('password');
    }

    /**
     * @return mixed|\think\response\Json
     * 修改用户密码
     */
    public function change_password()
    {
        if (request()->isAjax()) {
            $id = Request::instance()->param('id');
            $user = new  UserModel();
            $res = $user->getUser(['uid', $id]);
            if (!$res) {
                return json($this->return_arr('用户不存在'));
            }
            $temp_arr['salt'] = UserModel::createSalt();
            $password = UserModel::getRandChar(16);
            $temp_arr['password'] = UserModel::convertPassword($password, $temp_arr['salt']);

            if ($user->update($temp_arr, ['uid' => $res['uid']])) {
                return json($this->return_arr('密码：' . $password, true));
            } else {
                return json($this->return_arr('更新失败'));
            }
        }
        return $this->fetch('password');
    }

}