<?php
namespace app\census\controller;
use think\Controller;
use  app\census\model\PackageModel;
use  app\census\model\DownloadModel;

class Download extends Controller
{
    /**
     * 获取包下载链接，并记录下载日志
     */
    public function add()
    {
        if (request()->isAjax()) {
            $package = input('post.package');
            if(!$package){
                echo json_encode(['status'=>'fail','msg'=>'请输入完整链接']);
                exit;
            }
            $res = PackageModel::get(['pnumber'=>$package]);
            if(!$res){
                echo json_encode(['status'=>'fail','msg'=>'参数错误']);
                exit;
            }
            echo json_encode(['status'=>'success','url'=>$res->url]);
            $data['ip'] = get_client_ip();
            $data['pnumber'] = $package;
            $download = new  DownloadModel();
            $download->insertDownload($data);
        }
    }
}
