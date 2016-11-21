<li><a href="{{route('labels.index', ['model' => 'issues', 'slug_label' => $list->slug])}}"
        class="label" style="background:#{{$list->color}};color:#fff;">
        {{$list->title}}</a></li>
