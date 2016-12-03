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
