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

class DailyCensus extends Base
{
    //查询访问量
    public function run(){
        echo "DailyDownload\n";
        try {
            $temp = [];
            $stime = isset($this->params[0]) ? strtotime($this->params[0]) : strtotime('yesterday');
            $etime = $stime + 86400;
            $sql = "SELECT count(1) as visit_count,pnumber,system_os FROM xxwd_census   WHERE  create_time>=$stime AND  create_time<$etime GROUP BY pnumber ,system_os";
            $data = Db::query($sql);
            foreach ($data as $key => $val) {
                $temp['pnumber'] = isset($val['pnumber']) ? $val['pnumber'] : 'none';
                $temp['system_os'] = isset($val['system_os']) ? $val['system_os'] : 'none';
                $temp['visit_count'] = isset($val['visit_count']) ? $val['visit_count'] : 0;
                $temp['create_time'] = $stime;
                $insertData[] = "('" . implode("','", $temp) . "')";
            }
            if ($temp) {
                $value = implode(',', $insertData);
                $sql = "REPLACE INTO xxwd_daily_census (`pnumber`,`system_os`,`visit_count`,`create_time`) VALUES $value";
                Db::execute($sql);
                echo 'success';
            }else{
                echo 'no data';
            }
// 
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}


