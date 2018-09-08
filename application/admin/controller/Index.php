<?php
namespace app\admin\Controller;
use think\Controller;
use think\Request;
use think\Db;
/**
* 首页
*/
class Index extends Controller
{   
    //首页
    public function index(){
        return $this->fetch();
    }
    //统计
    public function count(){
        return $this->fetch();
    }

    public function person(){
        $rows = DB::table('admin')->select();
        $this->assign('row',$rows);
        return $this->fetch();
    }
}
