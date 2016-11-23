@section('title',  _('Sprints'))

@extends('layouts.master')

@section('breadcrumb')

<div class="page-heading">
    <div class="col-lg-6">
        <h2>{{_('Sprint')}} <span class="label label-default">{{$sprint->visibility}}</span></h2>
    </div>
    <div class="col-lg-6 text-right">
        @include('partials.lnk-favorite', ['favorite' => $sprint->favorite, 'type' => 'sprint',
            'id' => $sprint->id, 'btnSize' => 'btn-sm font-bold', 'text' => _('Favorite')])
        &nbsp;&nbsp;
        <div class="btn-group">
            <a href="{{route('sprints.edit', ['slug'=>$sprint->slug])}}"
                class="btn btn-sm btn-outline btn-primary font-bold"
                data-toggle="modal" data-target="#modalLarge">
                <i class="fa fa-pencil" aria-hidden="true"></i> {{_('Edit Sprint Backlog')}}</a>
            <form action="{{route('sprints.delete')}}" method="POST" class="form-delete">
                <input type="hidden" name="_token" value="{{csrf_token()}}" />
                <input type="hidden" name="_method" value="DELETE" />
                <input type="hidden" name="slug" value="{{$sprint->slug}}" />
                <button class="btn btn-sm btn-outline btn-primary font-bold btn-submit-form" type="submit">
                    <i class="fa fa-trash" aria-hidden="true"></i></a>
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@section('content')

<div class="row">

    <div class="col-lg-4">

        <div class="ibox">

            <div class="ibox-content">
                <a href="{{route('issues.index', ['slug'=>$sprint->slug])}}"
                    class="btn btn-lg btn-block btn-w-m btn-warning"><strong>{{_('Sprint Planning')}}</strong></a>

                <a href="{{route('issues.create', ['slug'=>$sprint->slug])}}"
                    class="font-bold btn btn-w-m btn-block btn-primary btn-outline"
                    data-toggle="modal" data-target="#modalLarge"><strong>{{_('Create Issue')}}</strong></a>
            </div>

            @include('partials.boxes.chart-donut', ['list' => $sprint->issueStatus()])

            <div class="ibox-content">

                <div class="m-t-none m-b-md">
                    @include('partials.boxes.progress-bar', [ 'percentage' => $sprint->getPercentcomplete()])
                </div>

                <table class="table small m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>{{$sprint->getEffort()}}</strong> {{_('effort')}}
                        </td>
                        <td>
                            <strong>22</strong> {{_('Team Velocity')}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{$sprint->issues->count()}}</strong> {{_('issues')}}
                        </td>
                        <td>
                            <strong>{{$sprint->issues->count()}}</strong> {{_('commits')}}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{count($sprint->issuesHasUsers())}}</strong> {{_('team members')}}
                        </td>
                        <td>
                            <strong>32</strong> Friends
                        </td>
                    </tr>
                    </tbody>
                </table>

                <div class="row m-t-sm">
                    <div class="col-xs-4">
                        <small class="stats-label">Additions</small>
                        <h4>{{$sprint->totalAdditions()}}</h4>
                    </div>
                    <div class="col-xs-4">
                        <small class="stats-label">PSR-2 Errors</small>
                        <h4>{{$sprint->getPSR2Errors()}}</h4>
                    </div>
                    <div class="col-xs-4">
                        <small class="stats-label">Bugs %</small>
                        <h4>76.43%</h4>
                    </div>
                </div>

            </div>

            @include('partials.boxes.issue-type', ['list' => $sprint->issueTypes()])

            @include('partials.boxes.note', [ 'list' => $sprint,
                'type'=> 'sprint', 'title' => _('Definition of Done Checklist for Sprint'),
                'percentage' => $sprint->notesPercentComplete()])

            @include('partials.boxes.attachment', ['id' => $sprint->id, 'type' => 'sprint', 'list' => $sprint->attachments])

            @include('partials.boxes.team', ['title' => 'Team Members', 'list' => $sprint->issuesHasUsers()])

        </div>

    </div>

    <div class="col-lg-8">

        <div class="ibox m-b-none">

            <div class="ibox-content" style="position: relative;">
                <h3>{{$sprint->title}} {{_('burndown')}}</h3>
                <div id="morris-area-chart" style="height: 230px;"></div>
            </div>

            <div class="ibox-content">

                <h2 class="m-b-md">
                    <span class="label label-danger pull-right"
                    style="font-size:16px;margin-top:3px;background-color:#{{$sprint->status->color}}">
                    {{$sprint->status->title}}</span>
                    <span @if ( $sprint->closed_at ) style="text-decoration: line-through;" @endif>
                    {{$sprint->title}}</span>
                </h2>

                <h4 class="m-b-none font-bold">{{_('Date')}}: {{$sprint->date_start}} {{_('to')}} {{$sprint->date_finish}}</h4>

                <p>{{$sprint->workingDays(date('Y-m-d'))}} {{str_plural('missing day', $sprint->workingDays(date('Y-m-d')))}} /
                    {{$sprint->workingDays()}} {{str_plural('workdays', $sprint->workingDays())}}
                    ( {{$sprint->weeks()}} {{str_plural('week', $sprint->weeks())}} )</p>

                <p class="m-b-xs small">
                    {{_('Product Backlog')}}: <a href="{{route('product_backlogs.show', ['slug' => $sprint->productBacklog->slug])}}">
                    <strong>{{$sprint->productBacklog->title}}</strong></a>
                </p>

                <p class=" m-t-md m-b-none">{!! nl2br(e($sprint->description)) !!}</p>

            </div>

            <div class="row">

                <div class="col-lg-12">

                    <div class="tabs-container">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-issues">
                                <i class="fa fa-list-alt" aria-hidden="true"></i>
                                {{_('Issues')}} ({{$sprint->issues->count()}})</a></li>
                            <li class=""><a data-toggle="tab" href="#tab-comments">
                                <i class="fa fa-comments" aria-hidden="true"></i>
                                {{_('Comments')}} ({{$sprint->comments->count()}})</a></li>
                            <li><a data-toggle="tab" href="#tab-activities">
                                <i class="fa fa-rss" aria-hidden="true"></i>
                                {{_('Activities')}}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="tab-issues" class="tab-pane active">
                                <div class="panel-body">

                                    @include('partials.boxes.search-min')

                                    @include('partials.boxes.issue', ['list' => $sprint->issues])

                                    <div class="project-list">

                                        <table class="table table-hover issue-tracker">
                                            <tbody>
                                            @each('partials.lists.issues', $sprint->issues, 'list', 'partials.lists.no-items')
                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div>
                            <div id="tab-comments" class="tab-pane">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="social-footer">
                                            <div class="social-comment">
                                                @include('partials.forms.comment', ['id'=>$sprint->id, 'type'=>'sprint'])
                                            </div>
                                        </div>
                                        <div class="m-t-md feed-activity-list">
                                            @each('partials.lists.comments', $sprint->comments, 'comment', 'partials.lists.no-items')
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="tab-activities" class="tab-pane ">
                                <div class="panel-body">
                                    <div class="feed-activity-list">
                                        @each('partials.lists.activities-complete', $sprint->activities(), 'activity', 'partials.lists.no-items')
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>


</div>

<script>
$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [
            @foreach($sprint->burdown() as $key=>$value)
            { period: '{{$key}}', issues: '{{$value}}' },
            @endforeach
        ],
        xkey: 'period',
        ykeys: ['issues'],
        labels: ['Issues Remaining'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true,
        lineColors: ['#87d6c6', '#54cdb4','#1ab394'],
        lineWidth:4,
        pointSize:4,
    });

});

</script>

@endsection
