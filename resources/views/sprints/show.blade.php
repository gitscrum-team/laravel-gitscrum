@section('title',  _('Sprint Backlog'))

@extends('layouts.master')

@section('breadcrumb')
<div class="col-lg-6">
    <h3>
        @if(isset($sprint->productBacklog->slug))
        <a href="{{route('product_backlogs.show', ['slug'=>$sprint->productBacklog->slug])}}">{{_('Product Backlog')}}</a> &raquo;
        @endif
        {{_('Sprint Backlog')}} <span class="label label-default">{{$sprint->visibility}}</span></h3>
</div>
<div class="col-lg-6 text-right">
    @include('partials.lnk-favorite', ['favorite' => $sprint->favorite, 'type' => 'sprint',
        'id' => $sprint->id, 'btnSize' => 'btn-sm font-bold', 'text' => _('Favorite')])
    &nbsp;&nbsp;
    <div class="btn-group">
        <a href="{{route('sprints.edit', ['slug'=>$sprint->slug])}}"
            class="btn btn-sm btn-primary"
            data-toggle="modal" data-target="#modalLarge">
            <i class="fa fa-pencil" aria-hidden="true"></i> {{_('Edit Sprint Backlog')}}</a>
        <form action="{{route('sprints.delete')}}" method="POST" class="form-delete pull-right">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE" />
            <input type="hidden" name="slug" value="{{$sprint->slug}}" />
            <button class="btn btn-sm btn-default btn-submit-form" type="submit">
                <i class="fa fa-trash" aria-hidden="true"></i></a>
            </button>
        </form>
    </div>
</div>
@endsection

@section('content')
    <div class="col-lg-4">

        <a href="{{route('issues.index', ['slug'=>$sprint->slug])}}"
            class="btn btn-lg btn-block btn-warning"><strong>{{_('Sprint Planning')}}</strong></a>

        <a href="{{route('issues.create', ['slug'=>$sprint->slug])}}"
            class="btn btn-block btn-primary"
            data-toggle="modal" data-target="#modalLarge"><strong>{{_('Create Issue')}}</strong></a>

        @include('partials.boxes.chart-donut', ['list' => $sprint->issueStatus()])

        <div class="">
            @include('partials.boxes.progress-bar', [ 'percentage' => $sprint->getPercentcomplete()])
        </div>

        <table class="table small m-b-xs">
            <tbody>
            <tr>
                <td width="50%">
                    <h6>{{$sprint->getEffort()}} {{_('effort')}}</h6>
                </td>
                <td width="50%">
                    <h6>{{$sprint->getEffortAvg()}} {{_('effort avg.')}}</h6>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <h6>{{$sprint->issues->count()}} {{_('issues')}}</h6>
                </td>
                <td width="50%"></td>
            </tr>
            </tbody>
        </table>

        <!--
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
        -->

        @include('partials.boxes.issue-type', ['list' => $sprint->issueTypes()])

        @include('partials.boxes.note', [ 'list' => $sprint,
            'type'=> 'sprint', 'title' => _('Definition of Done Checklist for Sprint'),
            'percentage' => $sprint->notesPercentComplete()])

        @include('partials.boxes.attachment', ['id' => $sprint->id, 'type' => 'sprint', 'list' => $sprint->attachments])

        @include('partials.boxes.team', ['title' => 'Team Members', 'list' => $sprint->issuesHasUsers()])

    </div>

    <div class="col-lg-8">

            <h4 class="mtn ptn">
                <span class="label label-danger pull-right"
                style="font-size:16px;margin-top:3px;background-color:#{{$sprint->status->color}}">
                {{$sprint->status->title}}</span>
                <span @if ( $sprint->closed_at ) style="text-decoration: line-through;" @endif>
                {{$sprint->title}}</span>
            </h4>

            <h6 class="mtn ptn">{{_('Date')}}: {{$sprint->date_start}} {{_('to')}} {{$sprint->date_finish}}</h6>

            <p>{{$sprint->workingDays(date('Y-m-d'))}} {{str_plural('missing day', $sprint->workingDays(date('Y-m-d')))}} /
                {{$sprint->workingDays()}} {{str_plural('workdays', $sprint->workingDays())}}
                ( {{$sprint->weeks()}} {{str_plural('week', $sprint->weeks())}} )</p>

            <p class="">
                {{_('Product Backlog')}}: <a href="{{route('product_backlogs.show', ['slug' => $sprint->productBacklog->slug])}}">
                <strong>{{$sprint->productBacklog->title}}</strong></a>
            </p>

            <p class="">{!! nl2br(e($sprint->description)) !!}</p>

            <div style="">
                <h4 class="lead mbn pbn">{{$sprint->title}} {{_('Burndown')}}</h4>
                <div class="row">
                    <canvas id="sprintBurndown" height="320" class="col-md-12"></canvas>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="tabs-container mtl">

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
                            @include('partials.forms.comment', ['id'=>$sprint->id, 'type'=>'sprint'])
                            @each('partials.lists.comments', $sprint->comments, 'comment', 'partials.lists.no-items')
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

<script>
$(function() {

    var sprintBurnDown = $("#sprintBurndown");

    var data = {
    labels: [ @foreach($sprint->burdown() as $key=>$value) '{{$key}}', @endforeach ],
    datasets: [
        {
            label: "Issues",
            fill: true,
            lineTension: 0,
            height: 230,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 1,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [ @foreach($sprint->burdown() as $key=>$value) '{{$value}}', @endforeach ],
            spanGaps: false,
        }
    ]};

    var chartLine = new Chart(sprintBurnDown, {
        type: 'line',
        data: data,
        options: {
            responsive: false,
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: false
                    }
                }]
            }
        }
    });

});

</script>

@endsection
