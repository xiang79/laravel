4 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
</head>
<body>
    <form action="{{url('/index')}}" method="post">
         用户名：<input type="text" name="admin_name"><br>
         用户密码：<input type="password" name="admin_pass"><br>
         <input type="submit" value="登录">
    </form>
</body>
</html>