<?php
namespace app\admin\Controller;
use think\Controller;
use think\Request;
use think\Db;

/**
* 管理员管理
*/
class Admin extends Controller
{
    
    //管理员列表
    public function index(Request $request)
    {  

        // $rows =Db::table('users u,user_details l')
        //     ->where('u.uid = l.uid')
        //     ->where("u.identity='1'")
        //     ->field('u.uid,u.uname,l.tel,l.email,u.addtime,l.status')
        //     ->select();
        $num = DB::table('admin')->select();
        $rows = DB::table('admin')->paginate(4);
        $this->assign('num',count($num));
        $this->assign('rows',$rows);
        return $this->fetch();
    }

    //管理员添加
    public function add(Request $request)
    {   
        //判断是否是get请求
        if ($request->method()=='GET') 
        {
           return $this->fetch();

        //判断是否是post请求
        }elseif($request->method()=='POST')
        {
            $data = [//接收前台所有的数据
                'name' => $request->param('uname'),
                'password' => md5($request->param('password')),
                'tel' => $request->param('tel'),
                'email'=>$request->param('email'),
                'status' => 1,
                'identity' => 1,
                'addtime' => date('Y-m-d H:i:s',time()),
            ];
            $res = Db::table('admin')->insert($data);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
    }

    //管理员修改
    public function edit(Request $request)
    {   
        if ($request->method()=='GET') 
        {   
            $uid = $request->param('uid');
            $res = DB::table('admin')->where('uid',$uid)->find();
            $this->assign('res',$res);
            return $this->fetch();
        //判断是否是post请求
        }elseif($request->method()=='POST')
        {
            $uid = $request->param('uid');
            $data = [
                'tel' => $request->param('tel'),
                'email' => $request->param('email'),
            ];

            $res = Db::table('admin')->where('uid',$uid)->update($data);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
        
    }

    //管理员删除
    public function del(Request $request)
    {
        $uid = $request->param('uid');
        $res = DB::table('admin')->where('uid',$uid)->delete();  
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

    //修改密码
    public function edit_password(Request $request)
    {   
        if ($request->method()=='GET'){
            $uid = $request->param('uid');
            $res = DB::table('admin')->where('uid',$uid)->find();
            $this->assign('res',$res);
            return $this->fetch();
        //判断是否是post请求
        }else if($request->method()=='POST'){
            $uid = $request->param('uid');
            $password = md5($request->param('password'));
            $res = Db::table('admin')->where('uid',$uid)->setField('password',$password);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
    }

    //管理员禁用
    public function stop(Request $request)
    {
        $uid = $request->param('uid');
        $res = DB::table('admin')->where('uid',$uid)->setField('status','2');
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }

    //管理员启用
    public function start(Request $request)
    {
        $uid = $request->param('uid');
        $res = DB::table('admin')->where('uid',$uid)->setField('status','1');
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
    
}