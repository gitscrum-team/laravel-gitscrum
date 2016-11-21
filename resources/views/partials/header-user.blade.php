<div class="profile-image m-t-sm">
    <img src="{{$user->avatar}}" class="img-rounded m-b-md" alt="{{$user->username}}">
</div>
<div class="profile-info  m-t-none">
    <h2 class="m-t-none">{{$user->username}}</h2>

    <p class="m-t-none m-b-none font-bold">{{$user->position_held}}</p>
    <p class="m-t-none">{{$user->location}}</p>
    <small>{{$user->bio}} Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</small>
</div>

<!--

    <div class="col-md-6">
        <table class="table small m-b-xs">
            <tbody>
            <tr>
                <td><a href=""><strong>{{$user->organizations->count()}}</strong> {{_('organizations')}}</a></td>
                <td><a href=""><strong>{{$user->issues->count()}}</strong> {{_('commits')}}</a></td>

            </tr>
            <tr>
                <td>
                    <strong>61</strong> Comments
                </td>
                <td>
                    <strong>54</strong> Articles
                </td>
            </tr>
            <tr>
                <td>
                    <strong>154</strong> Tags
                </td>
                <td>
                    <strong>32</strong> Friends
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
-->
