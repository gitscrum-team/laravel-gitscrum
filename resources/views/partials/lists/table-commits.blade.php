<tr>
    <td><a href="{{route('user.profile', ['username'=>$commit->user->username])}}">
        <img src="{{$commit->user->avatar}}" class="avatar-min" /></a></td>
    <td>{{$commit->message}}<br>
        <small>{{$commit->created_at}}</small></td>
    <td>{{$commit->branch->name}}</td>
    <td><a href="{{$commit->html_url}}" target="_blank"><i class="fa fa-github-alt" aria-hidden="true"></i></a></td>
</tr>
