<?php
/**
 * Created by PhpStorm.
 * User: zhuchengru
 * Date: 2016/10/8 0008
 * Time: 下午 6:39
 * 用户模型
 */
namespace app\census\model;

use think\Model;

class PackageModel extends Model
{
    protected $table = 'xxwd_package';
    protected $pk = 'pid';
    protected $type = [
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'update_time' => 'timestamp:Y-m-d H:i:s',
    ];

    /**
     * @return false|\PDOStatement|string|\think\Collection
     * 获取用户列表
     */
    public function getPackage()
    {
        return $this->select();
    }
}