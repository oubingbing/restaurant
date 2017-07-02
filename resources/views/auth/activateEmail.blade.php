<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>确认邮箱</title>
</head>
<body>
<p>hi,{{ $user->email }}</p>
激活账号链接：<a href="{{ $url }}">{{ $url }}</a>
</body>
</html>