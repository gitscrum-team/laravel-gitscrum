<tr>
    <td>@include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'product_backlog',
        'id' => $list->id, 'btnSize' => 'btn-xs' ])</td>
    <td><span class="label label-default">{{$list->visibility}}</span></td>
    <td>
        <a href="{{route('product_backlogs.show', ['slug' => $list->slug])}}">
        <span class="text-success">{{$list->title}}</span></a></td>
    <td>{{$list->organization->title}}</td>
    <td class="text-right">
        {{$list->sprints->where('closed_at', NULL)->count()}} {{_('Open')}} /
        {{$list->sprints->where('closed_at', '!=', NULL)->count()}} {{_('Closed')}}
    </td>
    <td class="text-right">
        {{$list->issues->where('closed_at', NULL)->count()}} {{_('Open')}} /
        {{$list->issues->where('closed_at', '!=', NULL)->count()}} {{_('Closed')}}
    </td>
</tr>
