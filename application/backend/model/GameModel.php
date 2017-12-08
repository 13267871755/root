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

class GameModel extends Model
{
    protected $table = 'xxwd_game';
    protected $pk = 'gid';
    protected $type = [
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'update_time' => 'timestamp:Y-m-d H:i:s',
    ];

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取游戏
     */
    public function getGameList($feild = '*', $where = '', $order = '', $limit = '')
    {
        $res = Db::query("SELECT $feild FROM xxwd_game $where $order $limit");
        return $res;
    }

    /**
     * @param $data
     * @return array
     * 新增游戏
     */
    public function insertGame($data)
    {
        foreach ($data as $k => $v) {
            switch (true) {
                case empty($v):
                    return ['gname' => false, 'msg' => '参数不能为空'];
                    break;
            }
        }
        if ($this->where('gname', $data['gname'])->find()) {
            return ['flag' => false, 'msg' => '用户已存在'];
        }
        $result = $this->save($data);
        if (false === $result) {
            // 验证失败 输出错误信息
            return ['flag' => false, 'msg' => $this->getError()];
        } else {
            return ['flag' => true, 'msg' => '添加游戏成功'];
        }
    }


    public function updateGame($data)
    {

       foreach ($data as $k => $v) {
            switch (true) {
                case empty($v):
                    return ['flag' => false, 'msg' => '参数不能为空'];
                    break;
            }
        }
        
        $data['update_time'] = time();
        $id = $data['gid'];
        $res = Db::name('game')->where('gid', $id)->update($data);

        if (false === $res) {
            // 验证失败 输出错误信息
            return ['flag' => false, 'msg' => $this->getError()];
        } else {
            return ['flag' => true, 'msg' => '修改成功'];
        }
    }
}