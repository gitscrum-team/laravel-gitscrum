<tr>
    <td>@include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'sprint',
        'id' => $list->id, 'btnSize' => 'btn-xs'])</td>
    <td><span class="label label-default">{{$list->visibility}}</span>
        <span class="label label-primary" style="background-color:#{{$list->status->color}};">
            {{$list->status->title}}</span></td>
    <td><a href="{{route('sprints.show', ['slug'=>$list->slug])}}"><span class="text-success">{{$list->title}}</span></a></td>
    <td>{{$list->date_start}} {{_('to')}} {{$list->date_finish}}<br />
        <small>{{$list->weeks()}} {{str_plural('week', $list->weeks())}} / {{$list->issues->count()}} {{str_plural('issue', $list->issues->count())}} </small></td>
    <td>@include('partials.boxes.progress-bar', [ 'percentage' => $list->getPercentcomplete()])</td>
    <td class="avatar-xs">@each('partials.lists.users-min', $list->issuesHasUsers(), 'user', 'partials.lists.no-items')</td>
</tr>

<!--
<tr>
    <td style="width:10px">

    </td>
    <td class="project-status" style="width:10px">

    </td>
    <td class="project-title">

        <br/>
        <small><strong>{{_('Timebox')}}</strong>:


        <div class="m-t-sm m-b-xs">

        </div>

        <span title="{{_('Issues')}}"><i class="fa fa-th-list" aria-hidden="true"></i> {{$list->issues->count()}}</span>
        &nbsp;&nbsp;
        <span title="{{_('Effort')}}"><i class="fa fa-tachometer" aria-hidden="true"></i> {{$list->issues->count()}}</span>

    </td>
    <td class="project-people " align="right">

    </td>
</tr>
-->
