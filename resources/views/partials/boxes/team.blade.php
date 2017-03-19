@if(!empty($list[0]))

<div class="ui segment">
    <h3 class="ui header">
        {{ $title or trans('gitscrum.members')}}
        <div class="sub header">{{ $subtitle or '' }}</div>
    </h3>
    <div class="ui mini images">
        @each('partials.lists.users-min', $list, 'user', 'partials.lists.no-items')
    </div>
    <a href="{{route('team.index')}}">{{trans('gitscrum.list-team')}}</a>
</div>
@endif
