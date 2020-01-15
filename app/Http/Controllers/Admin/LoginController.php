<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLogin;
use App\Tools\Curl;
class LoginController extends  Controller{
     //展示登录页面
     public function login(){
         return view('admin.index');
     }
    //前台登录
    public function index(Request $request){
           $data=$request->input();
           $admin=AdminLogin::get();
           //dd($admin);
        if($data){ 
            session(['data'=>$data]);
            $res=AdminLogin::create([
                'admin_name'=>$data['admin_name'],
                'admin_pass'=>$data['admin_pass'],
            ]);
            
        }
        if($admin['last_accont'] ==1){
             $admin_id=$admin['admin_id'];
            $res=AdminLogin::where(['admin_id'=>$admin_id])->update(['last_accont'=>1]);
            echo '<script>alert("用户名或密码错误");location.href="/login";</script>';
       }
      

    }
}
