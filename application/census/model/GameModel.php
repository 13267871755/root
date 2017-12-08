<?php
namespace app\census\model;
use think\Db;
use think\Model;
/**
* 
*/
class GameModel extends Model
{
	
	function Mark($id)
	{
		if(isset($id)){
           $landing = Db::name('package')->field('monitoring_url,download_url')->where('mark',$id)->find();
        }else{
            $landing['monitoring_url'] = '';
            $landing['download_url'] = '';
        }
        $data['monitoring_url'] = trim($landing['monitoring_url']);
        $data['download_url'] = trim($landing['download_url']);
        return $data;
	}


	function Landing($url){
		$sql = "SELECT origin_page,new_page FROM xxwd_set_landing WHERE origin_page LIKE '%".$url."%' ORDER BY update_time DESC LIMIT 1";
        $res = Db::query($sql);
        return $res;
	}
}


?>