<?php
namespace App\Tools;
use App\Tools\Curl;
use Illuminate\Support\Facades\Cache;
class Wechat{
  const  appID="wx88fbaedf5e77f53e";
  const  appsecret="3396826a512ea8f06d2d0d614c2fcd9d";

    //回复文本消息
   public static function responseText($msg,$xmlObj){
    echo "<xml>
    <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
    <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
    <CreateTime>".time()."</CreateTime>
    <MsgType><![CDATA[text]]></MsgType>
    <Content><![CDATA[".$msg."]]></Content>
  </xml>";
  die;
   }
  
    /**
     * 回复图片信息
     */
    public static function responseImg($media_id,$xmlObj){
      echo "<xml>
      <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
      <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
      <CreateTime>".time()."</CreateTime>
      <MsgType><![CDATA[image]]></MsgType>
      <Image>
        <MediaId><![CDATA[".$media_id."]]></MediaId>
      </Image>
      </xml>";die;
    }

    /**
     * 图片接口  上传素材接口
     */
     public static function  uploadMedia($path,$data){
        //调用接口地址
        $access_token=Self::getToken();

        //  dd($access_token);
        $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$access_token}&type={$data}";
        // $img="/data/wwwroot/default/w.jpg";
        //$img='D:\xampp\htdocs\w.jpg';
        // dd($img);
        $data['media'] = new \CURLFile($path);
       
        $res=Curl::post($url,$data);
        $wechat_media_id=json_decode($res,1);
        // dd($wechat_media_id);
        $wechat_media_id=$wechat_media_id['media_id'];
        return $wechat_media_id;
     }

   //获取access_token值
  public static function getToken(){
    $access_token=Cache::get("access_token");
    if(empty($access_token)){
  
      //调接口
      $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appID."&secret=".Self::appsecret;
  
      //使用 get发送请求  file_get_contents  读取文件
      $data=file_get_contents($url);
  
     //数组转化成字符串
     $data=json_decode($data,true);
  
     $access_token=$data['access_token'];
     //var_dump($access_token);
     //写入文件
    //  file_put_contents("access_token.txt",$access_token);
    Cache::put('accesss_toke',$access_token,7200);
    }
        return $access_token;
   }

    /**
     *根据openID获取用户id
     */
    public static function responseId($openid){
      $access_token=Self::getToken();
      // $openid=$xmlObj->FromUserName;
      // dd($openid);
      //获取用户基本信息
      $url="https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
      $data=file_get_contents($url);
      $data=json_decode($data,1);
      return $data;
    } 


      /**
     *根据城市获取一周天气
     *k780
     */
    public static function getWeather($city){
       //调用天气接口地址
       $url="http://api.k780.com:88/?app=weather.future&weaid={$city}&&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json";

       //使用请求方式  GET POST
       //读取一个文件  url        file_get_contents
       $data=file_get_contents($url);

       //转换成数组
       $data=json_decode($data,true);
       // var_dump($data);die;
       $msg="";
       //进行foreach循环
       foreach($data['result'] as $key => $value){
           $msg .= $value['days']." ".$value['citynm']." ".$value['week']." ".$value['temperature']." ".$value['weather']."\r\n";
       }
       // var_dump($msg);die;
       return $msg;
    }


    /**
     * 网页授权获取用户openid
     * @return [type] [description]
     */
    public static function getOpenid()
    {
        //先去session里取openid 
        $openid = session('openid');
        //var_dump($openid);die;
        if(!empty($openid)){
            return $openid;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        // dd($code);
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".self::appID."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::appID."&secret=".self::appsecret."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            // dd($data);
            $data = json_decode($data,true);
            $data = $data['openid'];
            //获取到openid之后  存储到session当中
            session(['openid'=>$openid]);
            return $data;
            //如果是非静默授权 再通过openid  access_token获取用户信息
        }   
    }


   
      /**
     * 网页授权获取用户基本信息
     * @return [type] [description]
     */
    public static function getOpenidByUserInfo()
    {
        //先去session里取openid 
        $userInfo = session('userInfo');
        //var_dump($openid);die;
        if(!empty($userInfo)){
            return $userInfo;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".self::appID."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".self::appID."&secret=".self::appsecret."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            $access_token = $data['access_token'];
            //获取到openid之后  存储到session当中
            //session(['openid'=>$openid]);
            //return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $userInfo = file_get_contents($url);
            $userInfo = json_decode($userInfo,true);
            //返回用户信息
            session(['userInfo'=>$userInfo]);
            return $userInfo;
        }   
    }

    /**
     * 生成带参数的二维码   生成二维码
     */
    public static function  createTmpOrcode($status){
        $access_token=Self::getToken();
       
        //创建参数二维码接口
        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
        //请求数据
        $postData=[
          'expire_seconds'=>60,  //二维码的有效期
          'action_name'=>'QR_STR_SCENE',
          'action_info'=>[
                    'scene'=>[
                      'scene_str'=>$status
                    ],
          ],
        ];
        $postData=json_encode($postData);
        $data=Curl::post($url,$postData);
        $data=json_decode($data,true);
        if(isset($data['ticket'])){
          //通过ticket换取验证码
          $url="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$data['ticket'];
          return $url;
        }
        return false;
    } 
}