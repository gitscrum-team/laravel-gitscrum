<li id="card_{{$card->id}}" class="card-detail" data-value="{{$card->id}}">

    <h4><a href="{{route('issues.show', ['slug' => $card->slug])}}">{{$card->title}}</a></h4>

    <div class="team-members">
        @each('partials.lists.users-min', $card->users, 'user')
    </div>
    <p>{{str_limit($card->description, 120)}}</p>

    <div class="icons">

        @include('partials.boxes.issue-icons', ['issue' => $card])

        <a href="#" class="pull-right btn btn-xs btn-white">{{$card->type->name}}</a>

    </div>

</li>
