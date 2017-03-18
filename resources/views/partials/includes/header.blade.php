<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>@yield('page-title') - {{ env('APP_TITLE') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">

    <link rel="stylesheet" href="/css/semantic.min.css">
    <link rel="stylesheet" href="/css/core.css">

    <script src="/js/jquery.min.js"></script>
    <script src="/js/semantic.min.js"></script>
    <script src="/js/core.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style type="text/css">
        .main.container {
            margin-top: 40px;
        }
    </style>

</head>

<body class="{{$bodyClass or ''}}">

<div class="loader-area"></div>
