<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <link href="{{ AdminWeb() }}static/h-ui/css/H-ui.min.css" rel="stylesheet" type="text/css"/>
    <link href="{{ AdminWeb() }}static/h-ui.admin/css/H-ui.login.css" rel="stylesheet" type="text/css"/>
    <link href="{{ AdminWeb() }}static/h-ui.admin/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="{{ AdminWeb() }}lib/Hui-iconfont/1.0.8/iconfont.css" rel="stylesheet" type="text/css"/>
    <title>后台登录 - H-ui.admin v3.1</title>
</head>
<body>
<input type="hidden" id="TenantId" name="TenantId" value=""/>
<div class="header"></div>
<div class="loginWraper">
    <div id="loginform" class="loginBox">
   {{-- 表单验证提示 --}}
     @include('admin.public.msg')
        <form class="form form-horizontal" action="{{ route('admin.login') }}" method="post">
            {{-- laravel5.5--}}
            @csrf

            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60d;</i></label>
                <div class="formControls col-xs-8">
                    <input name="username" value="admin" type="text" placeholder="账户" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <label class="form-label col-xs-3"><i class="Hui-iconfont">&#xe60e;</i></label>
                <div class="formControls col-xs-8">
                    <input name="password" value="admin" type="password" placeholder="密码" class="input-text size-L">
                </div>
            </div>
            <div class="row cl">
                <div class="formControls col-xs-8 col-xs-offset-3">
                    <input name="" type="submit" class="btn btn-success radius size-L" value="登录">
                </div>
            </div>
        </form>
    </div>
</div>
<div class="footer">Copyright 你的公司名称 by H-ui.admin v3.1</div>
<script type="text/javascript" src="{{ AdminWeb() }}lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="{{ AdminWeb() }}static/h-ui/js/H-ui.min.js"></script>
</body>
</html>



<!-- 提示信息自动消失 -->
<script>
setTimeout("document.getElementById('k').style.display='none'",2000);
</script>
