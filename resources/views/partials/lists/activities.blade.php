<div class="feed-element">
    <a href="{{route('user.profile', ['username'=>$activity->user->username])}}" class="pull-left  mr10">
        <img alt="image" class="img-rounded avatar" src="{{$activity->user->avatar}}">
    </a>
    <div class="media-body">
        <small class="pull-right">{{$activity->dateforhumans}}</small>
        <strong>{{$activity->user->username}}</strong> {{$activity->configStatus->description}}
        <br>
        <small class="text-muted"></small>
    </div>
</div>
