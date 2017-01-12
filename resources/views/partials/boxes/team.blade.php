@if(!empty($list[0]))
<div class="team">
    <h4>{{ $title or trans('Members')}}</h4>
    <p class="small">{{ $subtitle or '' }}</p>
    <div class="users">
        @each('partials.lists.users-min', $list, 'user', 'partials.lists.no-items')
    </div>
</div>
@endif
