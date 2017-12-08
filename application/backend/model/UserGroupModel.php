<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/15
 * Time: 19:52
 * 用户组模型
 * author:iamzcr@gmail.com
 */
namespace app\backend\model;

use think\Model;

class UserGroupModel extends Model
{
    protected $table = 'xxwd_user_group';
    protected $pk = 'groupid';

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取用户组列表
     */
    public function getUserGroupList($field = '*')
    {

        return $this->field($field)->select();
    }

    /**
     * 新增用户组
     * @param $data
     * @return array
     */
    public function insertGroup($data)
    {
        foreach ($data as $k => $v) {
            switch (true) {
                case empty($v):
                    return ['flag' => false, 'msg' => '参数不能为空'];
                    break;

            }
        }
        $user_group = $this->where('name', $data['name'])->whereor('mark', $data['mark'])->find();
        if ($user_group) {
            return ['flag' => false, 'msg' => '信息已存在'];
        }
        if ($this->save($data)) {
            return ['flag' => true, 'msg' => '新增成功'];
        }
    }

    /**
     * @param $id
     * @return int
     * @throws \think\Exception
     * 删除用户组
     */
    public function del($id)
    {
        if ($id) {
            return $this->where(['groupid'=>$id])->delete();
        }
        return false;
    }
}