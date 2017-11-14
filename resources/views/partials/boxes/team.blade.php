@if(!empty($list[0]))
<div class="team">
    <h4 class="gs-card-title">{{ $title or trans('gitscrum.members')}}</h4>
    <p class="small">{{ $subtitle or '' }}</p>
    <div class="users gs-card-content">
        @each('partials.lists.users-min', $list, 'user', 'partials.lists.no-items')
    </div>
</div>
@endif
