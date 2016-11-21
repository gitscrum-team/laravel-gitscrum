<div class="ibox-content">
    <h3>{{ $title or _('Members')}}</h3>
    <p class="small">{{ $subtitle or '' }}</p>
    <div class="user-friends">
        @each('partials.lists.users-min', $list, 'user', 'partials.lists.no-items')
    </div>
</div>
