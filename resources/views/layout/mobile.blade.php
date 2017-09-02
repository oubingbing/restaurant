<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
</head>
<style>
  *{
      padding: 0px;
      margin: 0px;
  }
</style>
<body style="padding: 0px;margin: 0px">
<div id="app">
    @yield('content')
</div>
</body>
<script src="{{ asset('js/mobile.js') }}"></script>
</html>
