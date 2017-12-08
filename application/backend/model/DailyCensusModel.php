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

class DailyCensusModel extends Model
{
    protected $table = 'xxwd_daily_census';


    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取下载数据
     */
    public function getDailyCensusList($feild = '*', $where = '', $groupby = '' ,$order = '', $limit = '')
    {
        $res = Db::query("SELECT $feild FROM xxwd_daily_census  $where $groupby $order $limit");
        return $res;
    }
}
