<h4 class="gs-card-title">{{trans('gitscrum.issue-types')}}</h4>

<div class="gs-card-content">
    <ul class="tag-list list-inline">
        @each('partials.lists.issue-types', $list, 'list')
    </ul>
</div>
