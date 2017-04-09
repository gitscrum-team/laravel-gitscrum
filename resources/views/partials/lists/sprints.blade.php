<tr>

    @if(!isset($list->column) || in_array('tbody_sprintFavorite', $list->column))
        <td>
            @include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'sprints', 'id' => $list->id, 'btnSize' => 'btn-xs'])
        </td>
    @endif

    @if(!isset($list->column) || in_array('tbody_sprintLabels', $list->column))
        <td>
            <span class="label label-default">
                {{$list->visibility}}
            </span>
            <span class="label label-primary" style="background-color:#{{$list->status->color}};">
                {{$list->status->title}}
            </span>
        </td>
    @endif

    @if(!isset($list->column) || in_array('tbody_sprintBacklog', $list->column))
        <td>
            <a href="{{route('sprints.show', ['slug'=>$list->slug])}}">
                {{$list->title}}
            </a>
            <div class="details">
                @include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($list, 'issues')])
                <span>
                    <strong>{{trans('gitscrum.timebox')}}:</strong>
                    {{$list->timebox}} ( {{ $list->scopeWeeks(date('Y-m-d')) }} {{ str_plural(trans('gitscrum.week'), $list->scopeWeeks(date('Y-m-d'))) }})
                </span>
                <span>
                    <strong>{{trans('gitscrum.issues')}}:</strong> {{$list->issues->where('closed_at', NULL)->count()}}
                    {{trans('gitscrum.open')}} /
                    {{$list->issues->where('closed_at', '!=', NULL)->count()}} {{trans('gitscrum.closed')}}
                </span>
            </div>
        </td>
    @endif

    @if(!isset($list->column) || in_array('tbody_sprintProductBacklog', $list->column))
        <td class="text-right">
            <a href="{{route('product_backlogs.show', ['slug'=>$list->productBacklog->slug])}}" class="text-middle btn btn-link">
                {{$list->productBacklog->title}}
            </a>
        </td>
    @endif

</tr>