<div class="navbar navbar-default navbar-fixed-top" role="navigation">
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
                        href="#"
                        data-toggle="dropdown">
                        <img src="{{Auth::user()->avatar}}" class="img-rounded" width="24" />
                        &nbsp;&nbsp;
                        <span class="font-extra-bold">{{Auth::user()->username}}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a href="{{route('user.profile',['slug' => Auth::user()->username])}}">
                          <i class="fa fa-user" aria-hidden="true"></i>{{_('Profile')}}</a></li>
                      <li><a href="{{route('issues.index',['slug' => 0])}}">
                          <i class="fa fa-th" aria-hidden="true"></i>{{_('Planning')}}</a></li>
                      <li class="nav-divider"></li>
                      <li><a href="{{route('auth.logout')}}">
                          <i class="fa fa-sign-out"></i> {{_('Logout')}}</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
