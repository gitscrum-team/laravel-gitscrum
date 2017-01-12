<div class="notes">
    <h4>{{ $title or trans('Small Notes')}}</h4>

    @if(isset($percentage))
        @include('partials.boxes.progress-bar', [ 'percentage' => $percentage, 'title' => 'Completed'])
    @endif

    <div class="dd" id="nestable">
        <ul class="list-group">
            @each('partials.lists.notes-min', $list->notes, 'note')
        </ul>
    </div>

    @include('partials.forms.note', ['id'=> $list->id, 'type'=> $type])

</div>
