<div class="feed-element">
    <a href="{{route('user.profile', ['username'=>$activity->user->username])}}" class="pull-left">
        <img alt="image" class="img-rounded avatar-min" src="{{$activity->user->avatar}}">
    </a>
    <div class="media-body ">
        <small class="pull-right">{{$activity->dateforhumans}}</small>
        <strong>{{$activity->user->username}}</strong> {{_('changed status to')}} <strong>{{$activity->configStatus->title}}</strong>
        <br>
        <small class="text-muted"></small>
    </div>
</div>
