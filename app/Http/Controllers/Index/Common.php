<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Common extends Controller
{
    public $key='1904api';
    public $iv='1904190419041904';

    public $app_maps = [
        [
            'app_id'=> '1904-1',
            'app_key'=>'1904-1pass'
        ]
    ];
    //加密
    protected function AesEncrypt($data){
    	if(is_array($data)){
    		$data=json_encode($data);
        }
    	$encrypt=openssl_encrypt(
    		$data,
    		'AES-256-CBC',
    		$this->key,
    		1,
    		$this->iv
    	);


    	return base64_encode($encrypt);
    }

    //解密
    protected function AesDecrypt($encrypt){
    	$decrypt=openssl_decrypt(
    		base64_decode($encrypt),
    		'AES-256-CBC',
    		$this->key,
    		1,
    		$this->iv
    	);
    	return json_decode($decrypt,true);
    }
    
    /**
     * 客户端需要把APPId和appkey传递到服务器进行验证
     */
    public function getAppIdAndKey(){
        $app_id  = '1904api2';
        $app_key = '1904pass';
        
        return[
                'app_id'=>'1904api2',
                'app_key'=>'1904pass'
            ];
    }

    private function _createSign($data,$app_key){
          ksort($data);
          $json_str=json_encode($data);   #进行加密
          #进行拼接  加密
          return md5($json_str . 'app_key='.$app_key); 
    }
    /**
     * array $data 参数约束
     */
    protected function curlPost($api_url , array $data , $is_post=1){
            $ch = curl_init();  //初始化

            $app_safe=$this->getAppIdAndKey();
            $data['app_id'] = $app_safe['app_id'];
             #客户端添加时间戳和随机数  防止内容改变
             $data['rand']= rand(10000,99999);
             $data['time']=time();
             
            #生成签名   进行加密
            $all_data=[
                'data'=>$this->AesEncrypt($data),
                'sign'=>$this->_createSign($data,$app_safe['app_key'])
            ];


            if($is_post){
                curl_setopt($ch , CURLOPT_POST,1);      //设置
                curl_setopt($ch , CURLOPT_POSTFIELDS, $all_data);      //设置  加密值
            }else{
                $api_url = $api_url . '?' .http_build_query($data);
            }
            curl_setopt($ch , CURLOPT_URL , $api_url);
            curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
    }
}
