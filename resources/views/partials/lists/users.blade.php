<div class="ui raised  card">
    <div class="content">
        <div class="header">Cute Dog</div>
        <div class="meta">
            <span class="category">Animals</span>
        </div>
        <div class="description">
            <p></p>
        </div>
    </div>
    <div class="extra content">
        <div class="right floated author">
            <a href="{{route('user.profile', ['username' => $list->username])}}">
                <img class="ui avatar image" src="{{$list->avatar}}">
                {{$list->username}}</a>
        </div>
    </div>
</div>