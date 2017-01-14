<tr>
    <td style="width:10px">
        @include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'user_stories',
            'id' => $list->id, 'btnSize' => 'btn-xs' ])
    </td>
    <td class="project-title">
        <a href="{{route('user_stories.show', ['slug'=>$list->slug])}}">
            <span class="label label-danger m-l-xs pull-right" style="background-color:#{{$list->priority->color}}">
                {{$list->priority->title}}</span> <span class="text-info">{{$list->title}}</span></a>
            <p>{{ trans('Product Backlog') }}: <a href="{{route('product_backlogs.show', ['slug' => $list->productBacklog->slug])}}">
                {{$list->productBacklog->title}}</a></p>
        <div class="m-b-sm m-t-sm">
            @include('partials.boxes.progress-bar', [ 'percentage' => Helper::percentage($list, 'issues')])
        </div>
        <div class="avatar-xs">
            @each('partials.lists.users-min', $list->issuesHasUsers(12), 'user', 'partials.lists.no-items')
        </div>
    </td>
</tr>
