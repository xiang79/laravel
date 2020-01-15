<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ssegLogin;
class WechatController extends Controller
{
    public function index(){
        return view('api.reg');
    }
    public function index_do(){
        $data=request()->all();
        $appid="1001";
        $appSecret=md5(uniqid().rand(1000,9999));
        RegLogin::create([
            'reg_name'=>$data['reg_name'],
            'reg_pass'=>$data['reg_pass'],
            'appid'=>$appid,
            'appsecret'=>$appSecret
        ]);
        return redirect('/login');
    }

    public function login(Request $request){
        if($request->isMethod('get')){
            $data=request()->all();
            //查询表中数据
            $regInfo=RegLogin::where(['reg_name'=>$data['reg_name'],'reg_pass'=>$data['reg_pass']])->first();
            if($regInfo){
                session(['regInfo'=>$regInfo]);
                return redirect('login_out');
            }
        }
        return view('api.reg_do ');
    }

    public function login_out(){
      $reg=session('regInfo');
      return view('api.login_out',['reg'=>$reg]);
    }


}
