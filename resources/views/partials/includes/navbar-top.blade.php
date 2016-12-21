<header>
    <div class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" role="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <a href="{{route('user.dashboard')}}" class="navbar-brand">
                    <i class="fa fa-{{strtolower(Auth::user()->provider)}}" aria-hidden="true" data-toggle="tooltip" title="{{trans('You are you connected using')}} {{Auth::user()->provider}}" data-placement="bottom"></i>Git<strong>Scrum</strong></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="{{route('product_backlogs.index')}}">
                        {{trans('Product Backlog')}}</a></li>
                    <li><a href="{{route('sprints.index')}}">
                        {{trans('Sprint Backlog')}}</a></li>
                    <li><a href="{{route('team.index')}}">
                        {{trans('Team')}}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a aria-expanded="false" role="button" href="#" data-toggle="dropdown">
                            <img src="{{Auth::user()->avatar}}"
                                class="avatar" />{{Auth::user()->username}}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('user.profile',['slug' => Auth::user()->username])}}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                    {{trans('Profile')}}</a></li>
                            <li><a href="{{route('issues.index',['slug' => 0])}}">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                    {{trans('Planning')}}</a></li>
                            <li class="nav-divider"></li>
                            <li><a href="{{route('wizard.step1')}}">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                                    {{trans('Sync Repos/Issues')}}</a></li>
                            <li class="nav-divider"></li>
                            <li><a href="{{route('auth.logout')}}">
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    {{trans('Logout')}}</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
