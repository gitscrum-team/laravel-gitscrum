<li id="{{$userStory->id}}" class="card-detail" data-value="{{$userStory->id}}" style="border-left:3px solid #{{$userStory->priority->color}}">
    <h4><a href="{{route('user_stories.show', ['slug' => $userStory->slug])}}">{{$userStory->title}}</a>
        <small>{{$userStory->productBacklog->title}}</small>
    </h4>

    {{--<div class="team-members">--}}
        {{--@each('partials.lists.users-min', $card->users, 'user')--}}
    {{--</div>--}}
    <p>{{str_limit($userStory->description, 120)}}</p>

    <span class="label label-warning"> Priority:{{$userStory->priority->title}}</span>
    <div class="icons">
        {{ $userStory->issues->count() }} Issues
        <a class="btn btn-primary"
           role="button"
           data-toggle="collapse"
           href="#collapse{{$userStory->id}}" aria-expanded="true" aria-controls="collapse{{$userStory->id}}"
        >+</a>
        <div class="collapse" id="collapse{{$userStory->id}}">
            <div class="" >
                <div class="agile-list-scroll">
                    <ul class="sortable-list connectList agile-list"
                        style="margin: 0; padding: 0;"
                        data-value="0"
                    >
                        @foreach($userStory->issues as $oneIssue)
                            @include('partials.lists.agile-cards', ['card' => $oneIssue, 'sprint' => $sprint])
                        @endforeach
{{--                        @each('partials.lists.agile-cards', $userStory->issues, 'card', 'partials.lists.no-items')--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="options">--}}
        {{--<a href="{{route('user_stories.edit', ['slug' => $userStory->slug])}}"--}}
        {{--data-toggle="modal" data-target="#modalLarge">--}}
        {{--<i class="fa fa-pencil" aria-hidden="true"></i> {{trans('Edit Issue')}}</a>--}}
    {{--<div>--}}

    <div class="clearfix"></div>

</li>
