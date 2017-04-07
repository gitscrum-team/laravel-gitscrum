<select name="members[]" data-placeholder="Add members" class="chosen-select"
    multiple style="width:100%;">
    @foreach ( $users as $user)
        @if( isset($issue->users) )
            <option @if( $issue->users->where('id', $user->id)->count() ) selected @endif value="{{$user->id}}">{{$user->username}}</option>
        @else
            <option value="{{$user->id}}">{{$user->username}}</option>
        @endif
    @endforeach
</select>
