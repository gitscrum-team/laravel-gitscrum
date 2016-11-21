<select name="arr[]" data-placeholder="Add members" class="chosen-select"
    multiple style="width:100%;">
    @foreach ( $list as $item)
        @if( isset($item) )
            <option @if( $issue->labels->where('id', $item->id)->count() ) selected @endif value="{{$item->id}}">{{$item->title}}</option>
        @else
            <option value="{{$item->id}}">{{$item->title}}</option>
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
