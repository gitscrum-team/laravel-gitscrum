<div class="">
    <h4>{{ $title or trans('gitscrum.tags')}}</h4>
    @include('partials.forms.label', ['type' => $type, 'id' => $id])

    <ul class="tag-list list-inline" style="padding: 0">
        @foreach($list as $listItem)
            @include('partials.lists.labels', ['list' => $listItem , 'model' => camel_case($type) ])
        @endforeach
    </ul>

    <div class="clearfix"></div>
</div>
