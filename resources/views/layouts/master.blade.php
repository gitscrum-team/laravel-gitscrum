<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title') / {{ env('APP_TITLE') }}</title>

    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="/assets/css/animate.css" rel="stylesheet">
    <link href="/assets/css/plugins/chosen/chosen.css" rel="stylesheet">
    <link href="/assets/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
    <link href="/assets/css/plugins/summernote/summernote.css" rel="stylesheet">
    <link href="/assets/css/plugins/summernote/summernote-bs3.css" rel="stylesheet">
    <link href="/assets/css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="/assets/css/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
    <link href="/assets/css/plugins/fullcalendar/fullcalendar.print.css" rel='stylesheet' media='print'>
    <link href="/assets/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">

    <script src="https://use.fontawesome.com/efba505368.js"></script>

    <script src="/assets/js/jquery-2.1.1.js"></script>
    <script src="/assets/js/jquery-ui-1.10.4.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="/assets/js/jquery-ui.custom.min.js"></script>
    <script src="/assets/js/plugins/iCheck/icheck.min.js"></script>

    <script src="/assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="/assets/js/plugins/fullcalendar/moment.min.js"></script>

    <script src="/assets/js/inspinia.js"></script>
    <script src="/assets/js/plugins/pace/pace.min.js"></script>

    <script src="/assets/js/plugins/flot/jquery.flot.js"></script>
    <script src="/assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/assets/js/plugins/flot/jquery.flot.resize.js"></script>

    <script src="/assets/js/plugins/chartJs/Chart.min.js"></script>

    <script src="/assets/js/plugins/peity/jquery.peity.min.js"></script>

    <script src="/assets/js/demo/peity-demo.js"></script>

    <script src="/assets/js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="/assets/js/plugins/morris/morris.js"></script>
    <script src="/assets/js/plugins/chosen/chosen.jquery.js"></script>
    <script src="/assets/js/plugins/nestable/jquery.nestable.js"></script>
    <script src="/assets/js/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/assets/js/plugins/fullcalendar/fullcalendar.min.js"></script>
    <script src="/assets/js/plugins/summernote/summernote.min.js"></script>

    <script src="js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
    <script src="/assets/js/plugins/chartJs/Chart.min.js"></script>
    <script src="/assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

</head>

<body class="top-navigation">
    <div id="wrapper">
        <div id="page-wrapper">

            @if ( Auth::check() )

            <div class="row border-bottom black-bg" style="margin:25px">
                <nav class="navbar navbar-fixed-top" role="navigation">
                    <div class="navbar-header">
                        <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                            <i class="fa fa-reorder"></i>
                        </button>
                        <a href="{{route('user.dashboard')}}" class="navbar-brand">Git<strong>Scrum</strong></a>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar">
                        <ul class="nav navbar-nav">
                            <li><a href="{{route('product_backlogs.index')}}">
                                    {{_('Product Backlog')}} </a></li>
                            <li><a href="{{route('sprints.index')}}">
                                    {{_('Sprint Backlog')}} </a></li>
                            <li>
                                <a aria-expanded="false" role="button" href="#"> {{_('Documentation')}} </a>
                            </li>
                            <li class="dropdown">
                                <a aria-expanded="false" role="button" href="#"> {{_('Team')}} </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="avatar">
                                <a aria-expanded="false" role="button"
                                    href="{{route('user.profile', ['username' => Auth::user()->username])}}">
                                    <img src="{{Auth::user()->avatar}}" class="img-rounded" width="24" />
                                    &nbsp;&nbsp;
                                    <span class="font-extra-bold">{{Auth::user()->username}}</span>
                                </a>
                            </li>
                            <li><a href="login.html"><i class="fa fa-sign-out"></i></a></li>
                        </ul>
                    </div>
                </nav>
            </div>

            <div class="sidebard-panel hidden-md hidden-sm hidden-xs" style="left:0;" >
                
            </div>

            <div class="sidebard-panel hidden-md hidden-sm hidden-xs">

                <div class="m-b-md">

                    <h4 class="m-t-md">{{_('Issue Labels')}}</h4>

                    <ul class="tag-list" style="padding: 0">
                        @each('partials.lists.labels', Auth::user()->labels('issues'), 'list')
                    </ul>

                    <div class="clearfix"></div>

                </div>

                <div class="m-b-md">

                    <h4 class="m-t-md">{{_('Activities')}}</h4>

                    <div class="feed-activity-list">
                        @each('partials.lists.activities-complete', Auth::user()->activities(), 'activity', 'partials.lists.no-items')
                    </div>

                </div>

                <div class="m-b-md">

                    <h4 class="m-t-md">{{_('Team')}}</h4>
                    @include('partials.boxes.team', ['title' => '', 'list' => Auth::user()->team()])

                </div>

            </div>
            @endif

            <div class="wrapper wrapper-content">
                <div class="container">

                    @yield('breadcrumb')

                    <div class="clearfix"></div>

                    @include('errors.flash-message')
                    @include('errors.notification-message')

                    @yield('content')

                </div>
            </div>

        </div>
    </div>

    <div class="modal" id="gs-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-content"></div>
    </div>

    @include('partials.boxes.bug-report')

    <script type="text/javascript">
        $('.sparkpie').sparkline('html', { type: 'pie', height: '1.0em' });
    </script>

</body>

</html>
