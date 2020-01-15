<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\AdminLogin;
use App\Tools\Wechat;
use App\Tools\Curl;
use Session;
class ApiController extends Controller
{
 
   public function show(){
      echo 'index';
   }
   public function index(){
     return view('login.reglogin');
   }

   public function login_out(){
      $sessionId=session::getId();
      $data=request()->all();
      $where=[
         'admin_name'=>$data['admin_name']
      ];
      /**查询数据库 */
      $adminInfo=AdminLogin::where($where)->first();
      if(!$adminInfo){
          return back()->withErrors(['用户名错误']);
      }
      $last_accont=0;
      $created_at=1200;
      if($data['admin_pass'] == $adminInfo['admin_pass']){
         #session()->put();  存储
         session()->put('adminInfo',$adminInfo);
         // $res=session('adminInfo');
         // var_dump($res);
         $amdinInfo['last_accont']=$last_accont;
         $adminInfo['created_at']=time(); 
         $adminInfo['sessionId']=$sessionId;
         $adminInfo->save(); 
         echo  '<script>alert("登录成功");location.href="show";</script>';return;
      }else {
         if($adminInfo['status'] ==1){
            //echo '<script>alert("账号已锁定");location.href="/login";</script>';return;
            return redirect('login')->withErrors("账号已锁定!");exit;
         }

         /**登录失败   错误次数加一 */
         if($adminInfo['last_accont']  ==0){
            AdminLogin::where($where)->update(['last_accont'=>$adminInfo['last_accont']+1]);
            return redirect('login')->withErrors("密码错误，还有2次机会!");exit;
         }
         /**第一次报错 */
         if($adminInfo['last_accont'] == 1){
               AdminLogin::where($where)->update(['last_accont'=>$adminInfo['last_accont']+1]);
              // echo '<script>alert("密码错误，还有一次机会");location.href="/login";</script>';return;
              return redirect('login')->withErrors("密码错误，还有1次机会!");exit;
          }
           if($adminInfo['last_accont'] ==2){
            AdminLogin::where($where)->update(['last_accont'=>$adminInfo['last_accont']+1,'status'=>1]);
              // echo '<script>alert("账号已锁定");location.href="/login";</script>';return;
              return redirect('login')->withErrors("账号已锁定!");exit;
         }
      }
      if($adminInfo['last_accont'] >=3){
         $adminInfo['created_at']=time()+300;
         $adminInfo->save();
      }
   }
   
    //微信
   public function WeChat(Request $request){
      $status=md5(uniqid());
   //   echo 111;die;
   // \Cache::forget('access_token');exit;
      $resInfo=Wechat::createTmpOrcode($status);
      // var_dump($resInfo);
      return view('login.wechat',
      [
         'resInfo'=>$resInfo,
         'status'=>$status
      ]
   );
  }

  public function checkWechat(Request $request){
       $status=$request->status;
       $openid=\Cache::get($status);
       if($openid){
          return json_encode(['ret'=>1,'font'=>'扫描成功']);
       }else{
         return json_encode(['ret'=>2,'font'=>'未扫描']);
       }   
  }
}
