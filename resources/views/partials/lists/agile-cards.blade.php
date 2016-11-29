<li id="{{$card->id}}" class="card-detail" data-value="{{$card->id}}">

    <h4><a href="{{route('issues.show', ['slug' => $card->slug])}}">{{$card->title}}</a></h4>

    <div class="team-members">
        @each('partials.lists.users-min', $card->users, 'user')
    </div>
    <p>{{str_limit($card->description, 120)}}</p>

    <div class="icons">
        @include('partials.boxes.issue-icons', ['issue' => $card])
    </div>

    <a href="{{route('issue_types.index', ['sprint_slug' => @$card->sprint->slug,
        'type_slug' => $card->type->slug])}}">
        <span class="label label-primary" style="background-color:#{{$card->type->color}}">
    {{$card->type->title}}</span></a>

    <div class="clearfix"></div>

</li>
