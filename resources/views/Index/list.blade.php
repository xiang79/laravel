<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border=1>
        <tr>
            <td>ID</td>
            <td>商品名称</td>
            <td>竞拍开始时间</td>
            <td>起拍价格</td>
            <td>最低拍价</td>
            <td>竞价内容</td>
            <td>操作</td>
        </tr>
        @foreach($indexInfo as $v)
        <tr>
            <td>{{$v->pid}}</td>
            <td>{{$v->pname}}</td>
            <td>{{date("Y-m-d h:i:s",$v->p_time)}}</td>
            <td>{{$v->p_price}}</td>
            <td>{{$v->plow}}</td>
            <td>{{$v->pconnect}}</td>
            <td><a href="{{url('/getView',['pid'=>$v->pid])}}">竞拍</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>