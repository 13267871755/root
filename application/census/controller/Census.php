<?php
namespace app\census\controller;

use think\Controller;
use \think\Request;
use  app\census\model\CensusModel;

class Census extends Controller
{
    /**
     * 到达页面触发
     */
    public function add()
    {
        if (request()->isAjax()) {
            $res = 'error';
            $ip = get_client_ip();
            $data['pnumber'] = input('post.pnumber');
            $data['system_os'] = input('post.system_os');
            $data['system_version'] = input('post.system_version');
            $data['system_type'] = input('post.system_type');
            $data['view_type'] = input('post.view_type');
            $data['view_venv'] = input('post.view_venv');
            $data['user_cookie'] = input('post.user_cookie');
            $data['come_time'] = time();
            $data['ip_area'] = $ip ? get_ip_city($ip)[0] : "未知地区";
            $data['ip'] = $ip;
            $census = CensusModel::create($data);
            if ($census->cid) {
                $res = 'add ok';
            }
            echo json_encode($res);
        }
    }

    /**
     * 离开页面触发
     */
    public function leave()
    {
        if (request()->isAjax()) {
            $res = 'error';
            $user_cookie = input('post.user_cookie');
            $data['leave_time'] = time();
            $download = new  CensusModel();

            if ($download->save($data, ['user_cookie' => $user_cookie])) {
                $res = 'leave ok';
            }
            echo json_encode($res);
        }
    }
}
