<div class="feed-element">
    <a href="{{route('user.profile', ['username'=>$activity->user->username])}}" class="pull-left mr10">
        <img alt="{{$activity->user->username}}" class="avatar" src="{{$activity->user->avatar}}">
    </a>
    <div class="media-body">
        [{{$activity->statusesable_type}}]
        {{-- <a href="{{route($activity->statusesable_type.'s.show', ['slug'=>$activity->statusesable->slug])}}">
            {{$activity->statusesable->title}}
        </a>--}}
        <small class="text-default">{{$activity->configStatus->description}}</small>
        <small class="date-for-humans text-muted">{{$activity->dateforHumans()}}</small>
    </div>
</div>
