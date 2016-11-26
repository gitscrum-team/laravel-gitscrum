<div class="">
    <h6>{{_('General Attachments')}}</h6>
    <ul class="list-group" style="padding: 0">
        @each('partials.lists.attachments-min', $list, 'attachment', 'partials.lists.no-items')
    </ul>

    @include('partials.forms.attachment', ['type' => $type, 'id' => $id])

</div>
