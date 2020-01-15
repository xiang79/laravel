<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户列表</title>
    <script src="/min.js"></script>
</head>
<body>
    <table border=1>
        <tr>
            <td>ID</td>
            <td>用户名</td>
            <td>操作</td>
        </tr>
        @foreach($adminInfo as $v)
        <tr>
            <td>{{$v['admin_id']}}</td>
            <td>{{$v['admin_name']}}</td>
            <td><a href="javascript:;" class="btn" admin_id="{{$v['admin_id']}}">编辑</a>||<a href="">删除</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>
<script>
$(document).on('click','.btn',function(){
      var admin_id=$(this).attr('admin_id');
       $.ajax({
           url:"{{url('/edit')}}",
           data:{admin_id:admin_id},
           success:function(res){
              //console.log(res);
              if(res.ret==200){
                  alert(res.msg);
              }
           }
       });
});
</script>