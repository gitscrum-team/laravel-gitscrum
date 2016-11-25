<tr>
    <td style="width:10px">
        @include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'issue',
            'id' => $list->id, 'btnSize' => 'btn-xs' ])</td>
    <td width="200">
        <span class="label label-primary" style="background-color:#{{$list->type->color}}">
        {{$list->type->title}}</span>
        <span class="label label-primary" style="background-color:#{{$list->status->color}}">{{$list->status->title}}</span>
    </td>
    <td>
        <a href="{{route('issues.show', ['slug'=>$list->slug])}}">
            <span class="text-success" @if ( $list->closed_at ) style="text-decoration: line-through;" @endif>
                {{$list->title}}</span></a>
        <br />
        @include('partials.boxes.issue-icons', ['issue' => $list])
    </td>
    <td>{{@$list->sprint->name}}</td>
    <td class="avatar-xs" align="right">@each('partials.lists.users-min', $list->users, 'user', 'partials.lists.no-items')</td>
</tr>
