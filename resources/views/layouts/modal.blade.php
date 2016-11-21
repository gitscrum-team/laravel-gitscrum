<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') / {{ env('APP_TITLE') }}</title>

</head>

<body>

    <div id="wrapper">
        <div id="page-wrapper" class="white-bg">

            <div class="container-fluid">
                <a href="#" class="pull-right p-md" data-dismiss="modal"><i class="fa fa-close"></i> {{_('Close')}}</a>
            </div>

            <div class="wrapper wrapper-content">
                <div class="container">

                    @yield('content')

                </div>
            </div>
        </div>
    </div>

</body>

</html>
