<li><a href="{{route('issue_types.index', ['sprint_slug' => $list['sprint'], 'type_slug' => $list['slug']])}}"
        class="label" style="background:#{{$list['color']}};color:#fff;">
        {{$list['title']}} ({{$list['total']}})</a></li>
