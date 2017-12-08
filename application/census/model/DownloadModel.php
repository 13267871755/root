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

class DownloadModel extends Model
{
    protected $table = 'xxwd_download';
    protected $pk = 'did';
    protected $type = [
        'create_time' => 'timestamp:Y-m-d H:i:s',
        'update_time' => 'timestamp:Y-m-d H:i:s',
    ];

    /**
     * @param $data
     * 新增
     */
    public  function insertDownload($data)
    {
        $this->save($data);
    }
}
