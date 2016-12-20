<tr>

    @if(!isset($list->column) || in_array('tbody_sprintFavorite', $list->column))
    <td>@include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'sprint',
        'id' => $list->id, 'btnSize' => 'btn-xs'])</td>
    @endif

    @if(!isset($list->column) || in_array('tbody_sprintLabels', $list->column))
    <td>
        <span class="label label-default">{{$list->visibility}}</span>
        <span class="label label-primary" style="background-color:#{{$list->status->color}};">
            {{$list->status->title}}</span></td>
    @endif

    @if(!isset($list->column) || in_array('tbody_sprintBacklog', $list->column))
    <td>
        <a href="{{route('sprints.show', ['slug'=>$list->slug])}}">{{$list->title}}</a>
        <div class="details">
            @include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($list, 'issues')])
            <span><strong>{{trans('Timebox')}}:</strong> {{$list->timebox}} ({{$list->weeks()}} {{str_plural('week', $list->weeks())}})</span>
            <span><strong>{{trans('Issues')}}:</strong> {{$list->issues->where('closed_at', NULL)->count()}} {{trans('Open')}} /
            {{$list->issues->where('closed_at', '!=', NULL)->count()}} {{trans('Closed')}}</span>
        </div>
    </td>
    @endif

    @if(!isset($list->column) || in_array('tbody_sprintProductBacklog', $list->column))
    <td class="text-right"><a href="{{route('product_backlogs.show', ['slug'=>$list->productBacklog->slug])}}"
        class="text-middle">
        {{$list->productBacklog->title}}</span></td>
    @endif

</tr>
