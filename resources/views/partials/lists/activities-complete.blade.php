<div class="feed-element">
    <a href="{{route('user.profile', ['username'=>$activity->user->username])}}" class="pull-left">
        <img alt="image" class="img-rounded avatar-min" src="{{$activity->user->avatar}}">
    </a>
    <div class="media-body ">
        [{{$activity->statusesable_type}}] <a href="{{route($activity->statusesable_type.'s.show', ['slug'=>$activity->statusesable->slug])}}">
            {{$activity->statusesable->title}}</a>
        <br>
        <small class="text-primary">{{_('changed status to')}} <strong>{{$activity->configStatus->title}}</strong></small>
        <small class="pull-right text-muted">{{$activity->dateforhumans}}</small>
    </div>
</div>
