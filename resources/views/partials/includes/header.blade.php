<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ env('APP_TITLE') }}</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="//code.jquery.com/ui/1.11.4/themes/flick/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="/css/flat-ui.css" rel="stylesheet" type="text/css" />
    <link href="/css/core.css" rel="stylesheet" type="text/css" />
    <link href="/css/core.css" rel="stylesheet" type="text/css" />

    <script src="//code.jquery.com/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
    <script src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" type="text/javascript"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.0.0rc/js/bootstrap-switch.js"></script>

    <script src="/js/core.js" type="text/javascript"></script>

</head>

<body>
