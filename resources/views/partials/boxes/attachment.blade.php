<h4 class="gs-card-title">{{trans('gitscrum.general-attachments')}}</h4>
<div class="gs-card-content">
    <ul class="list-group">
        @each('partials.lists.attachments-min', $list, 'attachment', 'partials.lists.no-items')
    </ul>

    @include('partials.forms.attachment', ['type' => $type, 'id' => $id])
</div>

