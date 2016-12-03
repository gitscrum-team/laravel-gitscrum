<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') / {{ env('APP_TITLE') }}</title>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="//code.jquery.com/ui/1.11.4/themes/flick/jquery-ui.css" rel="stylesheet" type="text/css" />
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" rel="stylesheet" type="text/css" />
    <link href="/css/flat-ui.css" rel="stylesheet" type="text/css" />
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

    @if ( Auth::check() && (!isset($hideNavbar) || !$hideNavbar) )

        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                    </button>
                    <a href="{{route('user.dashboard')}}" class="navbar-brand">Git<strong>Scrum</strong></a>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{route('product_backlogs.index')}}">
                                {{_('Product Backlog')}} </a></li>
                        <li><a href="{{route('sprints.index')}}">
                                {{_('Sprint Backlog')}} </a></li>
                        <li>
                            <a aria-expanded="false" role="button" href="#"> {{_('Documentation')}} </a>
                        </li>
                        <li class="dropdown">
                            <a aria-expanded="false" role="button" href="{{route('team.index')}}"> {{_('Team')}} </a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="avatar">
                            <a aria-expanded="false" role="button"
                                href="{{route('user.profile', ['username' => Auth::user()->username])}}">
                                <img src="{{Auth::user()->avatar}}" class="img-rounded" width="24" />
                                &nbsp;&nbsp;
                                <span class="font-extra-bold">{{Auth::user()->username}}</span>
                            </a>
                        </li>
                        <li><a href="{{route('auth.logout')}}"><i class="fa fa-sign-out"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>

        @include('partials.includes.sidebar')

        @include('partials.boxes.bug-report')

    @endif

    <div class="container">

        @yield('breadcrumb')

        <div class="clearfix"></div>
        <hr />

        @include('errors.flash-message')
        @include('errors.notification-message')

        @yield('content')

    </div>

    <div class="modal" id="modalLarge" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"></div>
        </div>
    </div>

</body>

</html>
