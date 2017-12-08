<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/2
 * Time: 11:07
 */

namespace app\crontab\controller;

use think\Controller;
use think\Db;
use think\Exception;

class DailyDownload extends Base
{
    public function run()
    {
        echo "DailyDownload\n";
        try {
            $temp = [];
            $stime = isset($this->params[0]) ? strtotime($this->params[0]) : strtotime('yesterday');
            $etime = $stime + 86400;
            $sql = "SELECT count(1) as down_count,pnumber FROM xxwd_download   WHERE  create_time>=$stime AND  create_time<$etime GROUP BY pnumber ";
            $data = Db::query($sql);
            foreach ($data as $key => $val) {
                $temp['pnumber'] = isset($val['pnumber']) ? $val['pnumber'] : 'none';
                $temp['down_count'] = isset($val['down_count']) ? $val['down_count'] : 0;
                $temp['create_time'] = $stime;
                $insertData[] = "('" . implode("','", $temp) . "')";
            }

            if ($temp) {
                $value = implode(',', $insertData);
                $sql = "REPLACE INTO xxwd_daily_download (`pnumber`,`down_count`,`create_time`) VALUES $value";
                Db::execute($sql);
                echo 'success';
            } else {
                echo 'no data';
            }

        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}


