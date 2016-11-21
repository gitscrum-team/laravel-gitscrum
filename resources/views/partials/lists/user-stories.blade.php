<tr>
    <td style="width:10px">
        @include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'user_story',
            'id' => $list->id, 'btnSize' => 'btn-xs' ])
    </td>
    <td class="project-title">
        <a href="{{route('user_stories.show', ['slug'=>$list->slug])}}">
            <span class="label label-danger m-l-xs pull-right" style="background-color:#{{$list->priority->color}}">
                {{$list->priority->title}}</span> <span class="text-success">{{$list->title}}</span></a>
        <div class="m-b-sm m-t-sm">
            @include('partials.boxes.progress-bar', [ 'percentage' => $list->getPercentcomplete()])
        </div>
        <div class="avatar-xs">
            @each('partials.lists.users-min', $list->issuesHasUsers(12), 'user', 'partials.lists.no-items')
        </div>
    </td>
</tr>
