<div class="notes">
    <h4>{{ $title or trans('gitscrum.small-notes')}}</h4>

    @if(isset($percentage))
        @include('partials.boxes.progress-bar', [ 'percentage' => $percentage, 'title' => trans('gitscrum.completed')])
    @endif

    <div class="dd" id="nestable">
        <ul class="list-group">
            @each('partials.lists.notes-min', $list->notes, 'note')
        </ul>
    </div>

    @include('partials.forms.note', ['id'=> $list->id, 'type'=> $type])

</div>
