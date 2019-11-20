<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户登陆通知</title>
</head>
<body>
    <h3>姓名：{{$haha->truename}}</h3>
    <h3>当前IP：{{$haha->last_ip}}</h3>
    <h3>登陆时间：{{date("Y-m-d H:i:s")}}</h3>
    <h3>账号：{{$haha->username}}</h3>
    <hr>
    <img src="http://pic.eastlady.cn/uploads/tp/201707/9999/45c57bd601.jpg" />
</body>
</html>
