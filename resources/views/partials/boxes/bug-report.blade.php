<div class="feedback">
    <div class="tooltips">
        <div class="btn-group dropup">
            <button type="button" class="btn btn-success dropdown-toggle btn-circle btn-lg"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bug fa-2x" title="{{trans('gitscrum.bug-report')}}"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-left dropdown-menu-form">
                <li>
                    <div class="report">
                        <h6 class="mbm">
                            <i class="fa fa-bug"></i>
                            {{trans('gitscrum.bug-report')}}
                        </h6>
                        <form action="#" method="post">
                            {{ csrf_field() }}
                            <textarea required name="comment" class="form-control" placeholder="{{trans("gitscrum.please-tell-us-what-bug-or-issue-you-ve-found-provide-as-much-detail-as-possible")
                            }}"></textarea>
                            <button class="btn btn-primary btn-block mtm">{{trans('gitscrum.submit-report')}}</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
