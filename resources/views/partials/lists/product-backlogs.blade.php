<tr>
    <td width="30">@include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'product_backlogs',
        'id' => $list->id, 'btnSize' => 'btn-xs' ])</td>
    <td width="30"><span class="label label-default">{{$list->visibility}}</span></td>
    <td>
        <a href="{{route('product_backlogs.show', ['slug' => $list->slug])}}">
        {{$list->title}}</a>
        <div class="info">
            <span><strong>{{str_plural('User story', $list->userStories->count())}}</strong>: {{$list->userStories->count()}}</span>
            <span><strong>{{trans('Sprints')}}:</strong> {{$list->sprints->where('closed_at', NULL)->count()}} {{trans('Open')}} /
            {{$list->sprints->where('closed_at', '!=', NULL)->count()}} {{trans('Closed')}}</span>
            <span><strong>{{trans('Issues')}}:</strong> {{$list->issues->where('closed_at', NULL)->count()}} {{trans('Open')}} /
            {{$list->issues->where('closed_at', '!=', NULL)->count()}} {{trans('Closed')}}</span>
        </div>
    </td>
    <td><span class="text-middle">{{$list->organization->title}}</span></td>
    <td class="text-right" width="60">
        <a href="{{$list->html_url}}" target="_blank" class="text-middle icon-github"
            data-toggle="tooltip" data-placement="left"
            title="{{trans('Go to GitHub')}}" alt="{{trans('Go to GitHub')}}">
            <i class="fa fa-github" aria-hidden="true"></i></a>
    </td>
</tr>
