<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/15
 * Time: 19:51
 * 后台用户组管理控制器
 * author:iamzcr@gmail.com
 */
namespace app\backend\controller;

use  app\backend\model\UserGroupModel;
use \think\Request;

class UserGroup extends Base
{
    /**
     * @return mixed
     * 用户组首页
     */
    public function index()
    {
        return $this->fetch('index');
    }

    public function userGroupJson()
    {
        if (request()->isAjax()) {
            $user_group = new UserGroupModel();
            $data = $user_group->getUserGroupList('groupid,mark,name,description,create_time');
            foreach ($data as $k => $v) {
                $datas[] = [
                    $v['groupid'],
                    $v['mark'],
                    $v['name'],
                    $v['description'],
                    $v['create_time'],
                ];
            }
            $where = '1=1';

            return json([
                'aaData' => $datas,
                'iTotalRecords' => $user_group->count(1),
                'iTotalDisplayRecords' => $user_group->where($where)->count(1),
            ]);
        }
    }

    /**
     * @return mixed|\think\response\Json
     *
     */
    public function add()
    {
        $this->assign('data', []);
        return $this->fetch('edit');
    }

    public function edit()
    {
        $groupid = Request::instance()->param('groupid');
        $game = new UserGroupModel();
        $data = $game->where(['groupid' => $groupid])->find();
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     * @return \think\response\Json
     * 新增用户组操作
     */
    public function addData()
    {
        if (request()->isAjax()) {
            $data = Request::instance()->param('data');
            $temp_arr = parseParams($data);
            $user_group = new UserGroupModel();
            $res = $user_group->insertGroup($temp_arr);
            return json($this->return_arr($res['msg'], $res['flag'], url('user_group/index')));
        }
    }

    /**
     * @return mixed|\think\response\Json
     * 编辑用户组
     */
    public function editData()
    {
        if (request()->isAjax()) {
            $data = Request::instance()->param('data');
            $temp_arr = parseParams($data);
            foreach ($temp_arr as $k => $v) {
                if (empty($v)) {
                    return json($this->return_arr($k . '不能为空'));
                }
            }
            $groupid = $temp_arr['groupid'];
            unset($temp_arr['groupid']);
            $user = new UserGroupModel();
            if ($user->update($temp_arr, ['groupid' => $groupid])) {
                return json($this->return_arr('更新成功', true, url('user_group/index')));
            } else {
                return json($this->return_arr('更新失败'));
            }

        }
    }

    /**
     * @return \think\response\Json
     * 删除用户组
     */
    public function delete()
    {
        if (request()->isAjax()) {
            $id = Request::instance()->param('id');
            if ((new UserGroupModel())->del($id)) {
                return json($this->return_arr('删除成功', true, url('user_group/index')));
            } else {
                return json($this->return_arr('删除失败'));
            }
        }
    }
}

?>