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

class UserModel extends Model
{
    protected $table = 'xxwd_user';
    protected $pk = 'uid';
    protected $type = [
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'last_login_time' => 'timestamp:Y-m-d H:i:s',
        'expiration' => 'timestamp:Y-m-d H:i:s',
    ];

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取用户列表
     */
    public function getUserList()
    {
        return $this->select();
    }

    /**新增管理员
     * @param $data
     */
    public function insertUser($data)
    {
        foreach ($data as $k => $v) {
            switch (true) {
                case empty($v):
                    return ['flag' => false, 'msg' => '参数不能为空'];
                    break;

            }
        }
        if ($this->where('username', $data['username'])->find()) {
            return ['flag' => false, 'msg' => '用户已存在'];
        }
        $data['salt'] = self::createSalt();
        $password = self::getRandChar(16);
        $data['password'] = md5($data['password']);
        $data['loginnum'] = 0;
        $data['expiration'] = strtotime($data['expiration']);
        $data['last_login_time'] = time();
        $data['last_login_ip'] = request()->ip();
        $data['status'] = 1;
        $result = $this->save($data);
        if (false === $result) {
            // 验证失败 输出错误信息
            return ['flag' => false, 'msg' => $this->getError()];
        } else {
            return ['flag' => true, 'msg' => '添加用户成功'];
        }
    }

    /**
     * 创建随机密匙
     * @return string
     */
    static public function createSalt()
    {
        $rand = rand(0, 9999);
        return md5($rand);
    }

    /**
     * 处理明文密码
     * @param $password 待处理的明文密码
     * @param $salt 随机密匙
     * @return string 加密后的密码
     */
    static public function convertPassword($password, $salt)
    {
        $pwd = md5($salt . $password);
        return $pwd;
    }

    /**
     * 生成用户密码
     * @param $length
     * @return null|string
     */
    static function getRandChar($length)
    {
        $str = null;
        $strPol = "0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;

        for ($i = 0; $i < $length; $i++) {
            $str .= $strPol[rand(0, $max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }

    /**
     * @param $id
     * @return int
     * @throws \think\Exception
     * 删除id
     */
    public function del($id)
    {
        if ($id) {
            return $this->where(['uid' => $id])->delete();
        }
        return false;
    }

    /**
     * @param array $flag
     * @return array|false|\PDOStatement|string|Model
     * 查找单个用户
     */
    public function getUser($flag = [])
    {
        $k = $flag[0];
        $v = $flag[1];
        if ($k && $v) {
            return $this->where("$k", $v)->find();
        }
    }
}