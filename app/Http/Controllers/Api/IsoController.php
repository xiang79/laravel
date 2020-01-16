<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IsoController extends Controller
{
  public function index(){
      $appId = "101353491";  //应用账号id
      $appSecret = 'df4e46ba7da52f787c6e3336d30526e4'; //应用账号密码
      $redirect_uri = "http://www.iwebshop.com/index.php";//回调地址
//跳转到qq服务器 显示登录
      $url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id={$appId}&redirect_uri={$redirect_uri}&state=zzzz";
      header("location:".$url);

  }
    public  function code(){
        $code=$_GET['code'];
        $appId = "101353491";  //应用账号id
        $appSecret = 'df4e46ba7da52f787c6e3336d30526e4'; //应用账号密码
        $redirect_uri = "http://www.iwebshop.com/index.php";//回调地址
        //调用接口获取令牌
        $url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&client_id={$appId}&client_secret={$appSecret}&code={$code}&redirect_uri={$redirect_uri}";
        $data = file_get_contents($url);
        //截取
        $start = strpos($data,"="); //获取开始位置
        $end = strpos($data,"&"); //结束位置
        $access_token = substr($data,$start+1,$end-$start-1);  //截取

        $url = "https://graph.qq.com/oauth2.0/me?access_token={$access_token}";
        $data = file_get_contents($url);
//$data = 'callback( {"client_id":"101353491","openid":"B42BCFAFD457AAEBCDDA3605F7F09441"} );';
        $start = strpos($data,"("); //获取开始位置
        $end = strpos($data,")"); //结束位置
        $openidData = substr($data,$start+1,$end-$start-1);  //截取
        $openidData = json_decode($openidData,true);
        $openid = $openidData['openid'];

        $url = "https://graph.qq.com/user/get_user_info?access_token={$access_token}&oauth_consumer_key={$appId}&openid={$openid}";
        $data = file_get_contents($url);
        $data = json_decode($data,true);
        var_dump($data);die;

    }
    public function getindex(){
        return view('login.index');
    }

}
