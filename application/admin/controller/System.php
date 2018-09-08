<?php
namespace app\admin\Controller;
use think\Controller;
use think\Request;

/**
* 系统配置
*/
class system extends Controller
{
    //网站管理
    public function index()
    {
        return $this->fetch();
    }

    //
}