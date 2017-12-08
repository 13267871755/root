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

class CensusModel extends Model
{
    protected $table = 'xxwd_census';
    protected $pk = 'cid';
    protected $type = [
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'update_time' => 'timestamp:Y-m-d H:i:s',
        'come_time' => 'timestamp:Y-m-d H:i:s',
        'leave_time' => 'timestamp:Y-m-d H:i:s',
    ];
    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取统计数据
     */
    public function getCensusList($feild = '*', $where = '', $order = '', $limit = '')
    {
        $res = Db::query("SELECT $feild FROM xxwd_census $where $order $limit");
        return $res;
    }
}