<select name="members[]" data-placeholder="Add members" class="chosen-select"
    multiple style="width:100%;">
    @foreach ( $usersByOrganization as $user)
        @if( isset($issue->users) )
            <option @if( $issue->users->where('id', $user->id)->count() ) selected @endif value="{{$user->id}}">{{$user->username}}</option>
        @else
            <option value="{{$user->id}}">{{$user->username}}</option>
        @endif
    @endforeach
</select>

<script>
    var config = {
        '.chosen-select'           : {},
        '.chosen-select-deselect'  : {allow_single_deselect:true},
        '.chosen-select-no-single' : {disable_search_threshold:10},
        '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
        '.chosen-select-width'     : {width:"100%"}
        }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }
</script>
