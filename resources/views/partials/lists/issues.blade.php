<tr>
    <td style="width:10px">
        @include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'issue',
            'id' => $list->id, 'btnSize' => 'btn-xs' ])</td>
    <td width="200">
        <a href="{{route('issue_types.index', ['sprint_slug' => $list->sprint->slug, 'type_slug' => $list->type->slug])}}">
            <span class="label label-primary" style="background-color:#{{$list->type->color}}">
        {{$list->type->title}}</span></a>
        <span class="label label-primary" style="background-color:#{{$list->status->color}}">{{$list->status->title}}</span>
    </td>
    <td>
        <a href="{{route('issues.show', ['slug'=>$list->slug])}}">
            <span class="text-success" @if ( $list->closed_at ) style="text-decoration: line-through;" @endif>
                {{$list->title}}</span></a>
        @include('partials.boxes.issue-icons', ['issue' => $list])
    </td>
    <td>{{@$list->sprint->name}}</td>
    <td class="avatar-xs" align="right">@each('partials.lists.users-min', $list->users, 'user', 'partials.lists.no-items')</td>
</tr>
