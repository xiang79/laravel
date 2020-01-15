<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});  

Route::any('/login','Api\ApiController@index');
Route::any('/login_out','Api\ApiController@login_out');
Route::group(['middleware' => ['session']],function () {
 Route::any('/show','Api\ApiController@show');
});

//---------------微信带参数的二维码
Route::any('/wechat','Api\ApiController@WeChat');
Route::any('/checkWechat','Api\ApiController@checkWechat');
Route::any('demo/index','Api\Wechats@index');

// Route::any('/index','Api\Wechats@index');
// Route::domain('index.1904.com')->namespace('Index')->group(function () {
//     Route::get('/','ApiController@index');
//     Route::any('/indextest','ApiController@test');  
//     Route::any('/login','ApiController@login');   
  
// });
 
// Route::domain('Api.1904.com')->namespace('Api')->middleware('apis')->group(function () {
//     Route::get('/','ApiController@index');
//     Route::any('/login','ApiController@login');   
//     });


// Route::domain('wechat.1904.com')->namespace('Index')->middleware('reg')->group(function () {
//     Route::get('/','WechatController@index');
//     Route::get('/index_do','WechatController@index_do');
//     Route::get('/login','WechatController@login');
//     Route::get('/login_out','WechatController@login_out');
// //    Route::get('/createToken','WechatController@createToken');
// });

// Route::any('/admin','Admin\AdminController@admin');
// //--------------添加新用户
// Route::any('/add','Admin\AdminController@add');
// //-------------------用户列表
// Route::any('/list','Admin\AdminController@list');
// Route::any('/edit','Admin\AdminController@edit');
// //--------------展示前台登录页面
// Route::any('/login','Admin\LoginController@login');
// //-------------前台登录
// Route::any('/index','Admin\LoginController@index');


//竞价
// Route::any('/price','Index\IndexController@price');
// Route::any('/price_do','Index\IndexController@price_do');
// Route::any('/view','Index\IndexController@index');
// Route::any('/getView/{pid?}','Index\IndexController@getView');
