<?php
namespace app\admin\Controller;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
/**
* 登入
*/
class Login extends Controller
{
  //登入
  public function index(Request $request)
  {   
      if($request->method()=="GET"){
          return $this->fetch();
      }else if($request->method()=="POST"){
            $captcha = input('yzm');
            if(!captcha_check($captcha)){
                $this->error('您的验证码错误！');
            }else{
                $name = $request->param('name');
                $pass = md5($request->param('password'));
                $row = Db::table('admin')
                ->where("name",$name)
                ->where("password",$pass)
                ->find();
                if($row['identity'] <> 1){
                  $this->error('抱歉你没权限登入！');
                }else if($row['status'] == 2){
                  $this->error('抱歉您被禁止登入了！');
                }else if($row){
                  Session::set('name',$name);
                  Session::set('admin_id',$row['uid']);
                  Session::set('login',1);
                  $this->success("登录成功", url('Index/index'));
                }      
            }
      }
  }


  //退出
  public function logout()
  {
    session::clear();
    $this->error('退出成功！',url('Login/index'));

  } 
}