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

use  app\backend\model\CensusModel;
use  app\backend\model\PackageModel;
use think\Db;
use think\Exception;
class Census extends Base
{
    public function index()
    {
        $package = new PackageModel();
        $this->assign('packages',$package->getpnamelist()) ;
        return $this->fetch('index');
    }

    public function censusJson()
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

            $census = new CensusModel();
            $res = $census->getCensusList('*', $where, ' ORDER BY create_time DESC ', $limit);

            if ($res) {
                foreach ($res as $k => $v) {
                    $datas[] = [
                        $v['pnumber'],
                        $v['system_os'],
                        $v['system_version'],
                        $v['system_type'],
                        $v['ip'],
                        $v['ip_area'],
                        date('Y-m-d H:i:s',$v['come_time']),
                        date('Y-m-d H:i:s',$v['leave_time'])
                    ];
                }
                $result = [
                    "data" => $datas, //过滤后
                ];
                $result = array_merge($result, Db::query("SELECT COUNT(1) as recordsTotal FROM xxwd_census")[0], Db::query("SELECT COUNT(1) as recordsFiltered FROM xxwd_census $where")[0]);
            }
            return json($result);
        }
    }

     
}