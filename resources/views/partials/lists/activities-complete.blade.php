<div class="feed-element">
    <a href="{{route('user.profile', ['username'=>$activity->user->username])}}" class="pull-left">
        <img alt="image" class="img-rounded avatar-min" src="{{$activity->user->avatar}}">
    </a>
    <div class="media-body">
        [{{$activity->statusesable_type}}]
        <!--<a href="{{route($activity->statusesable_type.'s.show', ['slug'=>$activity->statusesable->slug])}}">-->
            {{$activity->statusesable->title}}
        <!--</a>-->
        <small class="text-default">{{$activity->configStatus->description}}</small>
        <small class="text-muted">{{$activity->dateforhumans}}</small>
    </div>
</div>
