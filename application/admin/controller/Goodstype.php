<?php
namespace app\admin\Controller;
use think\Controller;
use think\Request;

/**
* 商品类别
*/
class Goodstype extends Controller
{
    //分类加载
    public function index(){

        return $this->fetch();
    }
    //添加分类
    public function add(){
        return $this->fetch();
    }
}