<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\AdminLogin;

class Sessions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        #获取sessionId
        $sessionId=session::getId();
        /**获取adminInfo */
        $adminInfo=$request->session('adminInfo');
        //  var_dump($adminInfo);
        /**判断是否登录 */
        if(!$adminInfo){
            return '<script>alert("请先登录");location.href="/login";</script>';
        }  
        
        #根据查询数据进行判断
        //$admin=AdminLogin::where('admin_id',$adminInfo['admin_id'])->first();
        $admin=AdminLogin::first();
        // dd($admin);
        if($sessionId != $admin['sessionId']){
            return redirect('/login')->withErrors("您的账号已在其他地方登陆,请尽快修改密码或联系管理员!");
        }

        // if(time() > $adminInfo['created_at']){
        //     session()->forget('adminInfo');
        //     return redirect('login');
        // }else{
        //     AdminLogin::where(['admin_id'=>$adminInfo['admin_id']])->update(['created_at'=>time()+120]);
        // }



        // #防止多终端登录
        // if(AdminLogin::getSessionId() != $adminInfo->sessionId){
        //     echo '账号已在其他地方登陆';exit;
        // }
        // #20分钟未操作，则提示重新登录
        // if(time() > AdminLogin::getloginTime() + 1200){
        //     session()->forget('adminInfo');
        //     return redirect('login');
        // }
        // #一直操作，则更新过期时间
        // AdminLogin::updateloginTime();
        return $next($request);
     }
}
