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
 
