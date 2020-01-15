<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tools\Wechat;

class Wechats extends Controller
{


 
   public function index(Request $request){
      echo 111;exit;
         $echostr=$request->input("echostr");
       echo $echostr;die;
      $xmlStr =file_get_contents("php://input");
      // var_dump($xmlStr);
      file_put_contents("1.txt",$xmlStr);
        //把xml数据转化成对象
      $xmlObj=simplexml_load_string($xmlStr,'SimpleXMLElement',LIBXML_NOCDATA);
      // var_dump($xmlObj);
      #用户扫码关注事件
      if($xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe'){
              //(string)  强制转化为字符串
             $FromUserName=$xmlObj->FromUserName;
             $EventKey=$xmlObj->EventKey;#获取标识
             //ltrim  截取左边的字符
             $event=ltrim($EventKey,'qrscene_');
             if(!empty($event)){
                \Cache::put($event,$FromUserName,120);
                Wechat::responseText($xmlObj,"正在扫码登录，请稍后");
             }
      }

      
      if($xmlObj->MsgType == 'event' && $xmlObj->Event == 'SCAD'){
        //(string)  强制转化为字符串
       $FromUserName=(string)$xmlObj->FromUserName;
       $EventKey=(string)$xmlObj->EventKey;#获取标识
       //ltrim  截取左边的字符
       $event=ltrim($EventKey,'qrscene_');
       if(!empty($event)){
          \Cache::put($event,$FromUserName,120);
          Wechat::responseText($xmlObj,"正在扫码登录，请稍后");
       }
}
   }
}
