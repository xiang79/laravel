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

        return $next($request);
     }
}
