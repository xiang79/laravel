<?php

namespace App\Http\Middleware;

use Closure;

class ApiController
{
    public $key='1904api';
    public $iv='1904190419041904';


    public $app_maps = [
        [
            '1904-1'=> '1904-1pass',
            '1904-2'=>'1904-2pass'
        ]  
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $data=$request->post('data');
        $decrypt_data=$this->AesDecrypt($data);
        //print_r($data);exit;
        #验证客户端签名
        $check=$this->checkSign($decrypt_data);
        if($check['status'] != 200){
           return  response($check);
        }else{
           return $next($request);
        }
        // var_dump( $check);
        
    }

    private function checkSign($decrypt_data){
         ksort($decrypt_data);
         $client_sign=request()->post('sign');
         #判断app_id是否存在
         if(isset($this->app_maps[$decrypt_data['app_id']])){
            $json = json_encode($decrypt_data). 'app_key=' .$this->app_maps[$decrypt_data['app_id']];
            if($client_sign == md5($json)){
                 return [
                'status' =>'200',
                'msg'=>'success',
                'data'=>md5($json)
               ];
            }else{
                return [
                    'status' =>'6666',
                    'msg'=>'check sign fail',
                    'data'=>[]
               ];
            }
           
         }else{
            return [
                 'status' =>'6666',
                 'msg'=>'check sign fail',
                 'data'=>[]
            ];
         }
    }
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
}
