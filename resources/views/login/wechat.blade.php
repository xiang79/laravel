<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="min.js"></script>
    <style>
     img{
        width:189px;
        height:189px;
    }
    </style>
   
</head>
<body>
<div align="center">
<h2>欢迎使用微信登录</h2>  <p>微信扫描下方二维码，直接登陆</p>
<img src="{{$resInfo}}"><br>
<a href="">账号密码登陆</a>
</div>  
</body>
</html>
<script>
status=setInterval(status,600000);
function status(){
     var status="{{$status}}";
   $.ajax({
      url:"{{url('/checkWechat')}}",
      data:{status:status},
      dataType:json,
      success:function(res){
        console.log(res);
        if(res.ret ==1){
            alert('res.font');
        }else{
            alert('res.font');
        }
      }
   });
}
  
clearInterval(status);
</script>