<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/15
 * Time: 19:51
 * 后台用户管理控制器
 * author:iamzcr@gmail.com
 */
namespace app\backend\controller;


use think\Controller;
use think\Db;
use think\Exception;
use app\backend\model\PackageModel;
use app\backend\model\DailyDownloadModel;

class DailyDownload extends Base
{

    public function index()
    {
        $this->assign('package_lists', (new PackageModel())->getpnamelist('pname,pnumber'));
        return $this->fetch('index');
    }

    public function dailyDownloadJson()
    {
        if (request()->isAjax()) {

            $where = $datas = [];

            $param = input('param.');
            $result['draw'] = intval($param['draw']);
            $result['data'] = [];
            if (!empty($param['pnumber'])) {
                $where[] = " pnumber='{$param['pnumber']}' ";
            }
            if (!empty($param['stime'])) {
                $stime = strtotime($param['stime']);
                $where[] = " create_time>$stime ";
            }
            if (!empty($param['etime'])) {
                $etime = strtotime($param['etime']);
                $where[] = " create_time<$etime ";
            }

            $limit = "LIMIT {$param['start']},{$param['length']}";
            $where = $where ? "WHERE " . implode(' AND ', $where) : '';

            $daily_download = new DailyDownloadModel();
            $res = $daily_download->getDailyDownloadList(' sum(down_count) as down_count,create_time ', $where, 'GROUP BY create_time ', 'ORDER BY create_time DESC ', $limit);

            if ($res) {
                foreach ($res as $k => $v) {
                    $datas[] = [
                        date('Y-m-d', $v['create_time']),
                        $v['down_count'],
                    ];
                }
                $result = [
                    "data" => $datas, //过滤后
                ];
                $result['recordsTotal'] = count($datas);
                $result['recordsFiltered'] = count($datas);
            }
            return json($result);
        }

    }
}