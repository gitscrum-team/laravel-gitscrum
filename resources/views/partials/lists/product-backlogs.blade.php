<tr>
    <td width="30">@include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'product_backlogs',
        'id' => $list->id, 'btnSize' => 'btn-xs' ])</td>
    <td width="30"><span class="label label-default">{{$list->visibility}}</span></td>
    <td>
        <a href="{{route('product_backlogs.show', ['slug' => $list->slug])}}">
        {{$list->title}}</a>
        <div class="info">
            <span><strong>{{str_plural('User story', $list->userStories->count())}}</strong>: {{$list->userStories->count()}}</span>
            <span><strong>{{trans('gitscrum.sprints')}}:</strong> {{$list->sprints->where('closed_at', NULL)->count()}}
                {{trans
            ('gitscrum.open')}} /
            {{$list->sprints->where('closed_at', '!=', NULL)->count()}} {{trans('gitscrum.closed')}}</span>
            <span><strong>{{trans('gitscrum.issues')}}:</strong> {{$list->issues->where('closed_at', NULL)->count()}}
                {{trans
            ('gitscrum.open')}} /
            {{$list->issues->where('closed_at', '!=', NULL)->count()}} {{trans('gitscrum.closed')}}</span>
        </div>
    </td>
    <td><span class="text-middle">{{$list->organization->title}}</span></td>
    <td class="text-right" width="60">
        <a href="{{$list->html_url}}" target="_blank" class="text-middle icon-github"
            data-toggle="tooltip" data-placement="left"
            title="{{trans('gitscrum.go-to-gitHub')}}" alt="{{trans('gitscrum.go-to-gitHub')}}">
            <i class="fa fa-github" aria-hidden="true"></i></a>
    </td>
</tr>
