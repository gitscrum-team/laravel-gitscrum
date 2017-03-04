<div class="dropdown-activities">
    <div class="tooltips">
        <div class="btn-group dropup">
            <button type="button" class="btn btn-success dropdown-toggle btn-circle btn-lg"
                data-toggle="dropdown" data-target="dropdown-activities" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-rss fa-2x" aria-hidden="true" title="{{trans('Activities')}}"></i>
            </button>
            <ul id="dropdown-activities" class="dropdown-menu dropdown-menu-right dropdown-menu-form">
                <li>
                    <div class="report">

                        <h4 class="m-t-md">{{trans('Issue Labels')}}</h4>

                        <ul class="tag-list list-inline" style="padding: 0">
                            @each('partials.lists.labels', Auth::user()->labels('issues')->take(6), 'list')
                        </ul>

                        <div class="clearfix"></div>

                        <h4 class="m-t-md">{{trans('Activities')}}</h4>

                        <div class="feed-activity-list">
                            @each('partials.lists.activities-complete', Auth::user()->activities()->take(4), 'activity', 'partials.lists.no-items')
                        </div>

                        @include('partials.boxes.team', ['title' => 'Team', 'list' => Auth::user()->team()])

                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
