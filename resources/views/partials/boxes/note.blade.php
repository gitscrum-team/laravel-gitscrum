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


<script>

var updateOutput = function (e) {

var list = e.length ? e : $(e.target),
     output = list.data('output');
if (window.JSON) {
 output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
} else {
 output.val('JSON browser support required for this demo.');
}
};

// activate Nestable for list 1
$('#nestable').nestable({
group: 1
}).on('change', updateOutput);

// activate Nestable for list 2
$('#nestable2').nestable({
group: 1
}).on('change', updateOutput);

// output initial serialised data
updateOutput($('#nestable').data('output', $('#nestable-output')));
updateOutput($('#nestable2').data('output', $('#nestable2-output')));

$('#nestable-menu').on('click', function (e) {
var target = $(e.target),
     action = target.data('action');
if (action === 'expand-all') {
 $('.dd').nestable('expandAll');
}
if (action === 'collapse-all') {
 $('.dd').nestable('collapseAll');
}
});
</script>
