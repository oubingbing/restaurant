<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/test.css') }}">
</head>
<body>
<div class="container-wall" id="app">
    <nav class="navbar navbar-default">
        <div class="container-fluid container-nav">
            <div class="navbar-header" id="navbar-brand-home">
                <a class="navbar-brand" href="#" id="brand-home-title" style="font-weight: 900">古卡老屋</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if(isset($user))
                <div>
                    <div>
                        <ul class="nav navbar-nav navbar-right navbar-user">
                            <li><a href="#" id="navbar-user-name">{{ $user['username'] }}</a></li>
                        </ul>
                    </div>
                    <div class="user-info hidden">
                        <ul class="list-group">
                            <li><a href="#" class="user-item">个人中心</a></li>
                            <li><a href="#" class="user-item">账户设置</a></li>
                            <li><a href="{{ url('auth/logout') }}" class="user-item">退出</a></li>
                        </ul>
                    </div>
                </div>
                    @else
                    <ul class="nav navbar-nav">
                        <li><a href="#" id="home">首页 <span class="sr-only">(current)</span></a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#" class="login-url" id="login-url">登录</a></li>
                        <li><a href="" class="register-url" id="register-url">注册</a></li>
                    </ul>
                @endif

            </div>
        </div>
    </nav>

    @yield('content')

</div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/calendar.min.js') }}"></script>
<script>
    $(function () {
        $(".navbar-user").click(function () {
            $(".user-info").removeClass('hidden');
        });

        $(".user-info").mouseleave(function () {
            $(".user-info").addClass('hidden');
        });

        $(".user-item").mouseenter(function () {
            $(this).css('color','white');
        });
        $(".user-item").mouseleave(function () {
            $(this).css('color','gray');
        });
    });
</script>
</html>
