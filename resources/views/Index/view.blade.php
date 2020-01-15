<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>开始加价</h3>
    <form action="javascript:;" method="post">
        <table>
            <tr>
                <td>商品名称:</td>
                <td>{{$viewInfo->sname}}</td>
            </tr>
            <tr>
                <td>竞拍开始时间</td>
                <td>{{date("Y-m-d h:i:s",$viewInfo->p_time  )}}</td>
            </tr>
            <tr>
                <td>底价:</td>
                <td>{{$viewInfo->sname}}</td>
            </tr>
            <tr>
                <td>最低加价:</td>
                <td>{{$viewInfo->sname}}</td>
            </tr>
            <tr>
                <td>竞价内容:</td>
                <td>{{$viewInfo->sname}}</td>
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