<p style='color:red'>
  @if(!empty($errors->first() ))
       {{$errors->first()}}
  @endif
</p>
<form action="{{url('/login_out')}}" method="post">
@csrf
  账号:<input type="text" name="admin_name"><br>
  密码:<input type="text" name="admin_pass"><br>
  <input type="submit" value="登录">
  <br>
  <a href="{{url('/index')}}"><img src="\admin\img\Connect_logo_7.png"></a>
</form>
<script scr="min.js"></script>
