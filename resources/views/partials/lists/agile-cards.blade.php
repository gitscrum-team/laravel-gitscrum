<li id="{{$card->id}}" class="card-detail" data-value="{{$card->id}}" style="border-top:4px solid #{{$card->type->color}}">

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

    <span class="label label-warning"> Effort:{{$card->configEffort->title}}</span>

    <div class="options">
        <a href="{{route('issues.edit', ['slug' => $card->slug])}}"
        data-toggle="modal" data-target="#modalLarge">
        <i class="fa fa-pencil" aria-hidden="true"></i> {{_('Edit Issue')}}</a>
    <div>

    <div class="clearfix"></div>

</li>
