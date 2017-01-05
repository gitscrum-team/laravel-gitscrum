<tr>
    <td style="width:10px">
        @include('partials.lnk-favorite', ['favorite' => $list->favorite, 'type' => 'issue',
            'id' => $list->id, 'btnSize' => 'btn-xs' ])</td>
    <td style="width:10px">
        <div class="btn-group" role="group">
            <button type="button" class="btn btn-xs btn-primary dropdown-toggle font-bold" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" style="background-color:#{{$list->status->color}}">
                {{$list->status->title}}
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @foreach ($list->statusAvailable as $status)
                    <li>
                        <a href="{{route('issues.status.update', ['slug' => $list->slug,
                            'status' => $status->id])}}" class="font-bold btn btn-w-m
                            @if($status->id==$list->config_status_id) btn-success @else btn-default @endif
                                btn-block" style="border-left:10px solid #{{$status->color}}"
                                type="button">{{$status->title}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </td>
    <td style="width:10px">
        <a href="{{route('issue_types.index', ['sprint_slug' => @$list->sprint->slug, 'type_slug' => $list->type->slug])}}">
            <span class="label label-primary" style="background-color:#{{$list->type->color}}">
        {{$list->type->title}}</span></a>
    </td>
    <td>
        <a href="{{route('issues.show', ['slug'=>$list->slug])}}">
            <span class="title-issue" @if ( $list->closed_at ) style="text-decoration: line-through;" @endif>
                {{$list->title}}</span></a>
        @include('partials.boxes.issue-icons', ['issue' => $list])
    </td>
    <td>{{@$list->sprint->name}}</td>
    <td class="avatar-xs" align="right">@each('partials.lists.users-min', $list->users, 'user', 'partials.lists.no-items')</td>
</tr>
