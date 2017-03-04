<div class="bx-attachment">
    <h4>{{trans('gitscrum.general-attachments')}}</h4>
    <ul class="list-group">
        @each('partials.lists.attachments-min', $list, 'attachment', 'partials.lists.no-items')
    </ul>

    @include('partials.forms.attachment', ['type' => $type, 'id' => $id])

</div>
