<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>激活账号</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .form-title{
            width: 100%;
            margin: 20px auto;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="jumbotron">
        <div class="form-title"><h3>激活账号</h3></div>
        <form class="form-horizontal" id="form-post" method="post" action="{{ url('auth/activate',$user->activate_token) }}">
            <div class="form-group">
                <label for="inputUsername3" class="col-sm-2 control-label">用户名</label>
                <div class="col-sm-10">
                    <input type="text" name="username" class="form-control" id="inputUsername" placeholder="username">
                </div>
            </div>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="{{ $user->email }}">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
                <div class="col-sm-10">
                    <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">确认密码</label>
                <div class="col-sm-10">
                    <input type="password" name="password_confirmation" class="form-control" id="inputPassword3" placeholder="Password confirmation">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">提交</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(document).ready(function(){
        $("#form-post").submit(function(e){
            var self = $(this);
            $.post(self.attr("action"), self.serialize(), success, "json");
            return false;
            function success(ajaxdata){
                if(ajaxdata.status_code == 200){
                    alert(ajaxdata.message);
                }else{
                    alert(ajaxdata.message);
                }
            }
        });
    });
</script>
</body>
</html>