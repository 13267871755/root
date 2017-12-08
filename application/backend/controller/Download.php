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

use  app\backend\model\DownloadModel;
use  app\backend\model\PackageModel;
use think\Db;
use think\Exception;

class Download extends Base
{
    public function index()
    {
        $package = new PackageModel();
        $this->assign('packages',$package->getpnamelist()) ;
        return $this->fetch('index');
    }

    public function downloadJson()
    {
        if (request()->isAjax()) {

            $where = $datas = [];

            $param = input('param.');
            $result['draw'] = intval($param['draw']);
            $result['data'] = [];
            if (!empty($param['pnumber'])) {
                $where[] = " pnumber='{$param['pnumber']}' ";
            }

            $limit = "LIMIT {$param['start']},{$param['length']}";
            $where = $where ? "WHERE " . implode(' AND ', $where) : '';

            $download = new DownloadModel();
            $res = $download->getDownloadList('*', $where, ' ORDER BY create_time DESC ', $limit);

            if ($res) {
                foreach ($res as $k => $v) {

                    $datas[] = [
                        $v['pnumber'],
                        $v['ip'],
                        date('Y-m-d H:i:s', $v['create_time']),
                    ];
                }
                $result = [
                    "data" => $datas, //过滤后
                ];
                $result = array_merge($result, Db::query("SELECT COUNT(1) as recordsTotal FROM xxwd_download")[0], Db::query("SELECT COUNT(1) as recordsFiltered FROM xxwd_download $where")[0]);
            }
            return json($result);
        }
    }



   
}