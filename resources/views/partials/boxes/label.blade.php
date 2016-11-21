<div class="ibox">
    <div class="ibox-content">
        <h3>{{ $title or _('Tags')}}</h3>

        @include('partials.forms.label', ['type' => $type, 'id' => $id])

        <div class="clearfix"></div>

        <h3>{{ $title or _('Labels')}}</h3>
        <ul class="tag-list" style="padding: 0">
            @each('partials.lists.labels', $list, 'list')
        </ul>

        <div class="clearfix"></div>
    </div>

</div>
