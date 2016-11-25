<tr>
    <td class="sprint-favorite">@include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'sprint',
        'id' => $list->id, 'btnSize' => 'btn-xs'])</td>
    <td class="sprint-labels"><span class="label label-default">{{$list->visibility}}</span>
        <span class="label label-primary" style="background-color:#{{$list->status->color}};">
            {{$list->status->title}}</span></td>
    <td class="sprint-title"><a href="{{route('sprints.show', ['slug'=>$list->slug])}}"><span class="text-success">{{$list->title}}</span></a></td>
    <td class="sprint-timebox">
        <span class="">{{$list->date_start}} {{_('to')}} {{$list->date_finish}}</span>
        <p class="small">{{$list->weeks()}} {{str_plural('week', $list->weeks())}} / {{$list->issues->count()}} {{str_plural('issue', $list->issues->count())}} </p>
    </td>
    <td class="sprint-progress">@include('partials.boxes.progress-bar', [ 'percentage' => $list->getPercentcomplete()])</td>
    <td align="right" class="avatar-xs">@each('partials.lists.users-min', $list->issuesHasUsers(), 'user', 'partials.lists.no-items')</td>
</tr>
