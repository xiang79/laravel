<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>商品竞价</title>
</head>
<body>
     <h3>商品竞价</h3>
    <form action="{{url('/price_do')}}" method="post">
        <table>
            <tr>
                <td>商品名称:</td>
                <td><input type="text" name="pname"></td>
            </tr>
            <tr>
                <td>保证金:</td>
                <td><input type="text" style="width:70px" name="p_price">(元)</td>
            </tr>
            <tr>
                <td>底价:</td>
                <td><input type="text" style="width:70px" name="plow">(元)</td>
            </tr>
            <tr>
                <td>最低加价:</td>
                <td><input type="text" style="width:70px" name="p_lows">(元)</td>
            </tr>
            <tr>
                <td>竞价内容:</td>
                <td><textarea  cols="30" rows="10" name="pconnect"></textarea></td>
            </tr>
            <tr>
                <td>竞拍时间:</td>
                <td>
                    <input type="date" name="date">
                    -
                    <input type="time" name="time">
                </td><br>
                <td>结束时间</td>
                <td>
                    <input type="date" name="date1">
                    -
                    <input type="time" name="time1">
                </td>
            </tr>
            <tr>
                <td><input type="submit" value="添加"></td>
            </tr>
        </table>
    </form>
</body>
</html>