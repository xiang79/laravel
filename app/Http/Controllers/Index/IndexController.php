<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\IndexPrice;
class IndexController extends Controller
{    
    //展示添加视图
    public function price(){
        return view('index/index');
    }

    //执行添加
    public function price_do(){
        $data=request()->all();
        $p_time=$data['date']." ".$data['time'];
        $updated_at=$data['date1']." ".$data['time1'];
        $res=IndexPrice::create([
             'pname'=>$data['pname'],
             'p_price'=>$data['p_price'],
             'plow'=>$data['plow'],
             'p_lows'=>$data['p_lows'],
             'pconnect'=>$data['pconnect'],
             'p_time'=>strtotime($p_time),
             'updated_at'=>strtotime($updated_at)
        ]);
        // dd($res);
        return redirect('/view');
    }

    //展示
    public function index(){
        $indexInfo=IndexPrice::get();
        return view('index/list',['indexInfo'=>$indexInfo]);
    }

    //竞拍
    public function getView($pid){
        // echo $pid;die;
        $viewInfo=IndexPrice::where(['pid'=>$pid])->first();
        return view('index/view',['viewInfo'=>$viewInfo]);
    }
}
