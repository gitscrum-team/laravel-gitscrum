<div class="sidebar">

    <h4 class="m-t-md">{{_('Issue Labels')}}</h4>

    <ul class="tag-list list-inline" style="padding: 0">
        @each('partials.lists.labels', Auth::user()->labels('issues'), 'list')
    </ul>

    <div class="clearfix"></div>

    <h4 class="m-t-md">{{_('Activities')}}</h4>

    <div class="feed-activity-list">
        @each('partials.lists.activities-complete', Auth::user()->activities(), 'activity', 'partials.lists.no-items')
    </div>

    @include('partials.boxes.team', ['title' => 'Team', 'list' => Auth::user()->team()])

</div>
