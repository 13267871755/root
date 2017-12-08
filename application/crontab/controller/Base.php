<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/9 0009
 * Time: 下午 6:17
 */
namespace app\crontab\controller;
use think\Controller;
use think\Request;

class Base extends Controller
{
    public $paramArr = array();
    public $key;
    public $params;
    public function _initialize()
    {
        if(!Request::instance()->isCli()){
            die('error:错误的请求方式');
        }
        //传入参数，使用时自己定义，key 从4开始
        $this->paramArr = $_SERVER["argv"];

        //参数少于1，没有传入要执行的模块/控制器/方法
        if (empty($this->paramArr[1])) {
            die('usage: php cron.php arg');
        }
        if (count($this->paramArr) > 2) {
            $this->params = array_slice($this->paramArr, 2);
        }
        $this->key = config('key');
    }

    /**
     * @param $data
     * 打印
     */
    public function printCrontab($data){
        echo "\n dateTime:".date("Y-m-d H:i:s")."\n-----";
        print_r($data);
        echo "-----\n";
    }
}