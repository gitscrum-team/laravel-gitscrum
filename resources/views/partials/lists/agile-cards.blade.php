<li id="card_{{$card->id}}" data-value="{{$card->id}}">

    <div class="agile-detail">

        <div class="ibox m-b-xs">

                <h4><a href="{{route('issues.show', ['slug' => $card->slug])}}">{{$card->title}}</a></h4>

                <div class="team-members">
                    @each('partials.lists.users-min', $card->users, 'user')
                </div>
                <p>{{str_limit($card->description, 120)}}</p>

                <div class="m-t-sm">

                    @include('partials.boxes.issue-icons', ['issue' => $card])

                    <a href="#" class="pull-right btn btn-xs btn-white">{{$card->type->name}}</a>

                </div>

                <div class="clearfix"></div>

        </div>
    </div>
</li>
