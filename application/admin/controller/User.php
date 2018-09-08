<?php
namespace app\admin\Controller;
use think\Controller;
use think\Request;
use think\Db;
/**
* 用户管理
*/
class User extends Controller
{
    
    //用户列表
    public function index(Request $request)
    {   
        $rows =Db::table('users u,user_details l')
            ->where('u.uid = l.uid')
            ->where("u.identity='1'")
            ->field('u.uid,u.uname,l.tel,l.email,l.address,u.addtime,l.status')
            ->paginate(4);
        $this->assign('rows',$rows);
        return $this->fetch();
    }

    //用户添加
    public function add(Request $request)
    {
        if ($request->method()=='GET') 
        {
           return $this->fetch();

        //判断是否是post请求
        }elseif($request->method()=='POST')
        {
            $data = [//接收前台所有的数据
                'uname' => $request->param('uname'),
                'password' => md5($request->param('password')),
                'identity' => 1,
                'addtime' => date('Y-m-d H:i:s',time()),
            ];
            $uid = Db::table('users')->insertGetId($data);
            $res = [
                'uid' => $uid,
                // 'face' => $request->param('face'),
                'tel' => $request->param('tel'),
                'email'=>$request->param('email'),
                'address'=>$request->param('address'),
                'status' => 1,
            ];
            $res = Db::table('user_details')->insert($res);
            if($res){
                $this->success('添加成功','User/index');
            }else{
                $this->error('添加失败');
            }
        }
    }

    //用户修改
    public function edit(Request $request)
    {
        if ($request->method()=='GET') 
        {   
            $uid = $request->param('uid');
            $res = DB::table('users')->where('uid',$uid)->find();
            $this->assign('res',$res);
            return $this->fetch();
        //判断是否是post请求
        }elseif($request->method()=='POST')
        {
            $uid = $request->param('uid');
            $data = [
                'tel' => $request->param('tel'),
                'email' => $request->param('email'),
                'address' => $request->param('address'),
            ];
            $res = Db::table('user_details')->where('uid',$uid)->update($data);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
    }

    //用户删除
    public function del(Request $request)
    {
        $uid = $request->param('uid');
        $res = DB::table('users')->where('uid',$uid)->delete();  
        $data = DB::table('user_details')->where('uid',$uid)->delete();  
        if($res && $data){
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
            $res = DB::table('users')->where('uid',$uid)->find();
            $this->assign('res',$res);
            return $this->fetch();
        //判断是否是post请求
        }else if($request->method()=='POST'){
            $uid = $request->param('uid');
            $password = md5($request->param('password'));
            $res = Db::table('users')->where('uid',$uid)->setField('password',$password);
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
        $res = DB::table('user_details')->where('uid',$uid)->setField('status','2');
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
        $res = DB::table('user_details')->where('uid',$uid)->setField('status','1');
        if($res){
            echo 1;
        }else{
            echo 2;
        }
    }
}