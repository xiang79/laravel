<?php


namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ApiController extends Common
{

    public function test(){
		// openssl_public_encrypt(
		// 	'173076382683628392929183392378723343545',
		// 	$encrypt_data,
		// 	file_get_contents(public_path('/public.key')),   #公共路径 public_path
		// 	OPENSSL_PKCS1_PADDING
		// );
		// echo base64_encode($encrypt_data);exit;//对公钥进行加密

		 //非对称加密  公钥加密
		 $data = str_repeat('1234567890','15'); //150个字符
		 $i = 0;
		 $all = "";
		 while($str = substr($data,$i,117)){
			 openssl_public_encrypt(
				 $str,
				 $encrypt,
				 file_get_contents(public_path().'/public.key'),
				 OPENSSL_PKCS1_PADDING
			 );
 
 
			 $all .= $encrypt;
			 $i += 117;
		 }
		 $encrypt_data = base64_encode($all);
		 echo $encrypt_data;
 
 
		 echo "<hr/>";
 
 
		 //非对称加密  私钥解密
		 $i = 0;
		 $all = "";
		 $encrypt_data = base64_decode($encrypt_data);
		 while($str = substr($encrypt_data,$i,128)){
			 openssl_private_decrypt(
				 $str,
				 $decrypt_data,
				 file_get_contents(public_path('/private.key')),
				 OPENSSL_PKCS1_PADDING
			 );
			 $all .= $decrypt_data;
			 $i += 128;
		 }
		 echo $all;

    	// $arr=[
    	// 	'user_name'=>'zhangshan',
    	// 	'use_pass'=>'123456'
		// ];
		// //echo http_build_query($arr);exit;
    	// //dd($arr);
    	// $encrypt=$this->AesEncrypt($arr);
    	// echo $encrypt;
    	// $decrypt=$this->AesDecrypt($encrypt);
    	// echo '<pre/>';
    	// dd($decrypt);


	}
	
	
	
    public function index(){
		return view('api.login');
	}

	public function login(){
		$login_data=[
			  'use_name'=>'zhangsan',
			  'use_pass'=>'123456'
		];
		$login_api_url='http://api.1904.com/login';
		$api_result=$this->curlPost($login_api_url , $login_data);
	    print_r($api_result); 
	}
}