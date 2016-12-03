<div class="feedback">
    <div class="tooltips">
        <div class="btn-group dropup">
            <button type="button" class="btn btn-success dropdown-toggle btn-circle btn-lg"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bug fa-2x" title="{{_('Bug Report')}}"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-left dropdown-menu-form">
                <li>
                    <div class="report">
                        <h6 class="mbm">
                            <i class="fa fa-bug"></i>
                            {{_('Report Bug')}}
                        </h6>
                        <form action="#" method="post">
                            {{ csrf_field() }}
                            <textarea required name="comment" class="form-control" placeholder="{{_("Please tell us what bug or issue you've found, provide as much detail as possible")}}"></textarea>
                            <button class="btn btn-primary btn-block mtm">{{_('Submit Report')}}</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
