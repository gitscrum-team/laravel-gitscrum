@section('title',  _('Dashboard'))

@extends('layouts.master')

@section('content')

<div class="small-header">
    <div class="hpanel">
        <div class="panel-body">
            <div id="hbreadcrumb" class="pull-right">
                <ol class="hbreadcrumb breadcrumb">
                    <li><a href="index.html">Team</a></li>
                    <li>
                        <span>App views</span>
                    </li>
                    <li class="active">
                        <span>Contacts</span>
                    </li>
                </ol>
            </div>
            <h2 class="font-light m-b-xs">
                Dashboard
            </h2>
            <small>Show users list in nice and color panels</small>
        </div>
    </div>
</div>

<div class="content animate-panel">

    <div class="row">

        <div class="col-lg-12">

            <div class="hpanel">

                <div class="panel-heading">My Issues</div>

                <div class="panel-body list">

                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th></th>
                             <th></th>
                             <th>Task</th>
                             <th>Effort</th>
                             <th>Date</th>
                         </tr>
                    </thead>
                    <tbody>
                     @foreach($user->issues as $issue)
                     <tr>
                         <td>
                             <div class="dropdown">
                                 <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
                                     <i class="fa fa-cog" aria-hidden="true"></i>
                                 </button>
                                 <ul class="dropdown-menu">
                                     <li><a href="#">Detail</a></li>
                                     <li><a href="#">CSS</a></li>
                                     <li><a href="#">JavaScript</a></li>
                                 </ul>
                             </div>
                         </td>
                         <td><span class="label label-success">Open</span></td>
                         <td class="issue-info">
                             <a href="#">{{$issue->title}}</a>
                             <br/>
                             <small>{{str_limit($issue->description,120)}}</small>
                         </td>
                         <td>{{$issue->effort}}</td>
                         <td>{{$issue->created_at}}</td>
                     </tr>
                     @endforeach
                     </tbody>
                 </table>

             </div>

        </div>

        <div class="col-sm-4">

            @include('partials.moris-line', ['name' => 'Week - Last Commits', 'result' => $lastCommits, 'chart_id' => 'week_commits', 'chart_label' => 'Commits'])

        </div>

        <div class="col-sm-4">

            @include('partials.moris-line', ['name' => 'Week - Last Issues', 'result' => $lastIssues, 'chart_id' => 'week_issues', 'chart_label' => 'Issues'])

        </div>

        <div class="col-md-4">

            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption caption-md">
                        <i class="icon-bar-chart theme-font hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Best Team Members</span>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="table-scrollable table-scrollable-borderless">
                        <table class="table table-hover table-light">
                            <thead>
                                <tr class="uppercase">
                                    <th colspan="2"> MEMBER </th>
                                    <th> RATE </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bestMembers as $bestMember)
                                <tr>
                                    <td class="fit">
                                        <img class="user-pic" src="{{$bestMember['avatar']}}"> </td>
                                    <td>
                                        <a href="{{route('account.profile', ['username'=>$bestMember['username']])}}" class="primary-link">{{$bestMember['username']}}</a>
                                    </td>
                                    <td align="right">
                                        <span class="bold theme-font">{{$bestMember['rate']}}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <br>

                        <a href="javascript:;" class="btn default btn-block"> More details </a>

                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-sm-4">

            @include('partials.moris-bar', ['name' => 'Week - Commits vs. Issues', 'resultOne' => $lastCommits, 'resultTwo' => $lastIssues, 'chart_id' => 'week_commits_issues', 'chart_labelOne' => 'Commits', 'chart_labelTwo' => 'Issues'])

        </div>

        <div class="col-md-8 col-sm-8">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Pull Requests</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr class="uppercase">
                                <th colspan="2"> MEMBER </th>
                                <th> # Title </th>
                                <th> HEAD&nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                                &nbsp;BASE</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach(@$pullRequests as $pullRequest)
                        <tr>
                            <td class="fit">
                                <img class="user-pic rounded" src="{{$pullRequest['avatar']}}"> </td>
                            <td>
                                <a href="{{route('account.profile', ['username'=>$pullRequest['username']])}}" class="primary-link">{{$pullRequest['username']}}</a>
                            </td>
                            <td>
                                <a href="javascript:;" class="primary-link">#{{$pullRequest['number']}}: {{$pullRequest['title']}}</a><br>
                                <small>Commits: {{$pullRequest['commits']}} / {{$pullRequest['created_at']}}</small>
                            </td>
                            <td>{{$pullRequest['head_branch']}}
                                &nbsp;&nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                                &nbsp;{{$pullRequest['base_branch']}}</td>
                            <td align="right"><button type="button" class="btn btn-circle green btn-xs"> Merge </button></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="portlet light ">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <i class="icon-bubbles font-dark hide"></i>
                        <span class="caption-subject font-dark bold uppercase">Latest file changes</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-hover table-light">
                        <thead>
                            <tr class="uppercase">
                                <th colspan="2"> MEMBER </th>
                                <th> Status </th>
                                <th> Commit </th>
                                <th> Changes </th>
                                <th> Commited At </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($listCommitFiles as $commit)
                        <tr>
                            <td class="fit">
                                <img class="user-pic rounded" src="{{$commit->commit->user->avatar}}"> </td>
                            <td>
                                <a href="{{route('commit.selected', ['sha'=>$commit->sha])}}" class="primary-link">{{$commit->commit->user->username}}</a>
                            </td>
                            <td><strong>{{$commit->status}}</strong></td>
                            <td>
                                <a href="{{route('commit.selected', ['sha'=>$commit->sha])}}" class="primary-link">{{$commit->commit->message}}</a><br>
                                <small>{{$commit->filename}}</small>
                            </td>
                            <td>{{$commit->changes}}</td>
                            <td>{{$commit->commit->dateforhumans}}</td>
                            <td align="right"><button type="button" class="btn btn-circle blue btn-xs"> Details </button></td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="p-w-md m-t-sm">




        <div class="row">
            @if(count($organizations))
            @foreach($organizations as $organization)
                <div class="ibox">
                    <div class="ibox-title">
                        <h5><a href="" class="text-success">{{$organization['login']}}</a></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="col-sm-2">
                            <a href="" class="text-success"><img src="{{$organization['avatar_url']}}" class="pull-left"/></a>
                        </div>
                        <div class="col-sm-10">
                            <div class="team-members">
                                <a href="#"><img alt="member" class="img-circle" src="img/a4.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="img/a5.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="img/a6.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="img/a8.jpg"></a>
                                <a href="#"><img alt="member" class="img-circle" src="img/a7.jpg"></a>
                            </div>
                            <h4>Info about {{$organization['login']}}</h4>
                            <p>{{$organization['description']}}</p>
                            <div>
                                <span>Status of current project:</span>
                                <div class="stat-percent">32%</div>
                                <div class="progress progress-mini">
                                    <div style="width: 32%;" class="progress-bar"></div>
                                </div>
                            </div>
                            <div class="row m-t-sm">
                                <div class="col-sm-4">
                                    <div class="font-bold">PROJECTS</div>
                                    24
                                </div>
                                <div class="col-sm-6">
                                    <div class="font-bold">RANKING</div>
                                    3th
                                </div>
                                <div class="col-sm-4 text-right">
                                    <div class="font-bold">BUDGET</div>
                                    $190,325 <i class="fa fa-level-up text-navy"></i>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            @endforeach
            @endif
        </div>

    </div>


@endsection
