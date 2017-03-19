<script>
    $(document)
        .ready(function() {

            $('.ui.search')
                .search({
                    type          : 'category',
                    minCharacters : 3,
                    apiSettings   : {
                        onResponse: function(githubResponse) {
                            var
                                response = {
                                    results : {}
                                }
                                ;
                            // translate GitHub API response to work with search
                            $.each(githubResponse.items, function(index, item) {
                                var
                                    language   = item.language || 'Unknown',
                                    maxResults = 8
                                    ;
                                if(index >= maxResults) {
                                    return false;
                                }
                                // create new language category
                                if(response.results[language] === undefined) {
                                    response.results[language] = {
                                        name    : language,
                                        results : []
                                    };
                                }
                                // add result to category
                                response.results[language].results.push({
                                    title       : item.name,
                                    description : item.description,
                                    url         : item.html_url
                                });
                            });
                            return response;
                        },
                        url: 'http://api.github.com/search/repositories?q={query}'
                    }
                });

            $('.ui.menu .ui.dropdown').dropdown({
                on: 'hover'
            });
            $('.ui.menu a.item')
                .on('click', function() {
                    $(this)
                        .addClass('active')
                        .siblings()
                        .removeClass('active')
                    ;
                })
            ;


            $('.open__sidebar_notes').on('click', function(){
                $('.ui.sidebar')
                    .sidebar('toggle');
            });


        })
    ;


</script>

<header>
    <div class="ui fixed menu">
        <div class="ui container">

            <a href="{{route('user.dashboard')}}" class="header item">
                <i class="left {{strtolower(Auth::user()->provider)}} icon" aria-hidden="true" data-toggle="tooltip"
                   title="{{trans('gitscrum.you-are-you-connected-using')}} {{Auth::user()->provider}}"
                   data-placement="bottom"></i>Git<strong>Scrum</strong></a>

            <a href="{{route('product_backlogs.index')}}" class="item">
                {{trans('gitscrum.product-backlog')}}</a>

            <a href="{{route('sprints.index')}}" class="item">
                {{trans('gitscrum.sprint-backlog')}}</a>

            <a href="{{route('user_stories.index')}}" class="item">
                {{trans('gitscrum.user-stories')}}</a>

            <div class="right menu">

                <a class="item open__sidebar_notes"><i class="sticky note icon"></i>My Notes</a>

                <div class="ui dropdown item" tabindex="0">
                    <img src="{{Auth::user()->avatar}}"
                         class="ui avatar image" />{{Auth::user()->username}}
                    <i class="dropdown icon"></i>
                    <div class="menu transition hidden" tabindex="-1">
                        <div class="item">
                            <a href="{{route('user.profile',['slug' => Auth::user()->username])}}">
                                <i class="id card outline icon"></i>{{trans('gitscrum.profile')}}</a>
                        </div>
                        <div class="item"><i class="protect icon"></i>Permissions</div>
                        <div class="divider"></div>
                        <div class="item">
                            <a href="{{route('wizard.step1')}}">
                                <i class="retweet icon"></i>{{trans('gitscrum.sync-repos-issues')}}</a>
                        </div>
                        <div class="item">
                            <a href="{{route('auth.logout')}}">
                                <i class="power icon"></i>{{trans('gitscrum.logout')}}</a>
                        </div>
                    </div>
                </div>
                <div class="ui dropdown item" tabindex="0">
                    <i class="us flag"></i>
                    <i class="dropdown icon"></i>
                    <div class="menu transition hidden" tabindex="-1">
                        <div class="item"><i class="us flag"></i> English</div>
                        <div class="item"><i class="cn flag"></i> Chinese</div>
                        <div class="item"><i class="pt flag"></i> Portuguese</div>
                        <div class="item"><i class="it flag"></i> Italian</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--

    <div class="navbar navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" role="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <a href="{{route('user.dashboard')}}" class="navbar-brand">
                    <i class="fa fa-{{strtolower(Auth::user()->provider)}}" aria-hidden="true" data-toggle="tooltip"
                       title="{{trans('gitscrum.you-are-you-connected-using')}} {{Auth::user()->provider}}"
                       data-placement="bottom"></i>Git<strong>Scrum</strong></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="{{route('user_stories.index')}}">
                        {{trans('gitscrum.user-stories')}}</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{route('product_backlogs.index')}}">
                        {{trans('gitscrum.product-backlog')}}</a></li>
                    <li><a href="{{route('sprints.index')}}">
                        {{trans('gitscrum.sprint-backlog')}}</a></li>
                    <li>
                        <a aria-expanded="false" role="button" href="#" data-toggle="dropdown">
                            <img src="{{Auth::user()->avatar}}"
                                class="avatar" />{{Auth::user()->username}}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('user.profile',['slug' => Auth::user()->username])}}">
                                <i class="fa fa-user" aria-hidden="true"></i>
                                    {{trans('gitscrum.profile')}}</a></li>
                            <li><a href="{{route('issues.index',['slug' => 0])}}">
                                <i class="fa fa-th" aria-hidden="true"></i>
                                    {{trans('gitscrum.planning')}}</a></li>
                            <li class="nav-divider"></li>
                            <li><a href="{{route('team.index')}}">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                    {{trans('gitscrum.team')}}</a></li>
                            <li><a href="{{route('wizard.step1')}}">
                                <i class="fa fa-refresh" aria-hidden="true"></i>
                                    {{trans('gitscrum.sync-repos-issues')}}</a></li>
                            <li class="nav-divider"></li>
                            <li>
                                <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    -->

</header>

