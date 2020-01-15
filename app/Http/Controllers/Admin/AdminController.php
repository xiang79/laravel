<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLogin;
use App\Tools\Curl;
class AdminController extends  Controller{
        //后台首页
        public function admin(){
            // $data=session('data');
            // // dd($data);
            // $admin_id=$data['admin_id'];
            // $volit=AdminLogin::where(['admin_id'=>$data['admin_id']])->first();
           // echo $volit;
           return view('admin.admin');
        }

        //添加新用户
        public function  add(Request $request){
            if($request->isMethod('Post')){
                 $data=$request->all();
                 return redirect('/list');
            }
              return view('admin.add');    
        }

        //用户列表
        public function list(){
            //接受所有值
           $adminInfo=AdminLogin::get()->toArray();
           return view('admin.list',['adminInfo'=>$adminInfo]);    
        }

          public function edit(Request $request){
                  $admin_id=$request->admin_id;
                //   dd($admin_id);
                  $res=AdminLogin::where(['admin_id'=>$admin_id])->update(['last_accont'=>3]);
                   return json_encode(['ret'=>200,'msg'=>'只能错误三次']);
                }
       
}
?>