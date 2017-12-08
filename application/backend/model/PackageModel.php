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
     * 获取包列表
     */
    public function getPackageList($feild = '*', $where = '', $order = '')
    {   
          $res = Db::name('package')->where($where)->order($order)->paginate(10,false,['query'=>request()->param()]);
            return $res;
    }

    public function getpnamelist($feild = '*', $where = '', $order = '' ,$limit = ''){
        $res =  Db::query("SELECT $feild FROM xxwd_package $where $order $limit"); 
         return $res;
    }
    public function foreachp($res){
         $datas = [];
            if ($res) {
                foreach ($res as $k => $v) {
                    $url = url('package/update',['pid'=>$v['pid']]);
                    $option = '<a href="javascript:void(0)" onclick="delete_package(' . $v['pid'] . ')" class="btn btn-danger btn-sm" >删除</a> ';
                    $update = "<a href='{$url}'  class='btn btn-primary pull-left' >修改</a>";
                    $datas[] = [
                        'gid' => $v['gid'],
                        'pname' => $v['pname'],
                        'pnumber' => $v['pnumber'],
                        'page_url' => 'http://landing.shxingwan.com/census/'.$v['page_url'],
                        'url' => $v['url'],
                        'monitoring_url' => $v['monitoring_url'],
                        'download_url' => $v['download_url'],
                        'products' => $v['products'],
                        'media' => $v['media'],
                        'create_time' => date('Y-m-d,H:i:s', $v['create_time']),
                        'username' => $v['username'],
                        'option' => $option,
                        'update' => $update
                    ];
                }
            }

            return $datas;
    }

    public function getPackageList_url($feild = '*', $where = '', $order = '', $limit = '')
    {
        $res = Db::query("SELECT $feild FROM xxwd_package $where $order $limit");
        return $res;
    }

    /**新增管理员
     * @param $data
     */
    public function insertPackage($data)
    {
        if(session('username') != '风腾'){
           foreach ($data as $k => $v) {
                switch (true) {
                    case empty($v):
                        return ['flag' => false, 'msg' => '参数不能为空'];
                        break;
                }
            } 
        }
        
        if ($this->where('pname', $data['pname'])->find()) {
            return ['flag' => false, 'msg' => '包已存在'];
        }
        $res = Db::name('game')->where('gid',$data['gid'])->find();
        $data['products'] = $res['gname'];
        if(empty($data['mark'])){
            $data['page_url'] = $data['url_s'].'/pnumber/'.$data['pnumber'];
        }else{
            $data['page_url'] = $data['url_s'].'/pnumber/'.$data['pnumber'].'/id/'.$data['mark'];
        }
        
        unset($data['url_s']);
        $result = $this->save($data);
        if (false === $result) {
            // 验证失败 输出错误信息
            return ['flag' => false, 'msg' => $this->getError()];
        }else{
            return ['flag' => true, 'msg' => '添加包成功'];
        }
    }

    public function updatePackage($data)
    {

       if(session('username') != '风腾'){
           foreach ($data as $k => $v) {
                switch (true) {
                    case empty($v):
                        return ['flag' => false, 'msg' => '参数不能为空'];
                        break;
                }
            } 
        }
        
        $data['update_time'] = time();
        $id = $data['pid'];

        if(empty($data['mark'])){
            $data['page_url'] = $data['url_s'].'/pnumber/'.$data['pnumber'];
        }else{
            $data['page_url'] = $data['url_s'].'/pnumber/'.$data['pnumber'].'/id/'.$data['mark'];
        }
        unset($data['url_s']);
        $res = Db::name('package')->where('pid', $id)->update($data);

        if (false === $res) {
            // 验证失败 输出错误信息
            return ['flag' => false, 'msg' => $this->getError()];
        } else {
            return ['flag' => true, 'msg' => '修改成功'];
        }
    }

    public function gamelist(){
        $res = Db::name('game')->field('gid,gname')->select();
        return $res;
    }
    
    public function usernamelist(){
        $rester['username'] = Db::query("SELECT username FROM xxwd_package employee group by username");
         $rester['products'] =  Db::query("SELECT products FROM xxwd_package employee group by products");
          $rester['media'] = Db::query("SELECT media FROM xxwd_package employee group by media");
        return $rester;
    }

    public function page($id){
        $datas = Db::name('package')->where('pid',$id)->find();
        $datas['page_url'] = substr($datas['page_url'],0,strrpos($datas['page_url'],'/pnumber'));
        return $datas; 
    }
}