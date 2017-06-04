<div class="">

    <form method="get" action="" class="pull-right mail-search">
    <div class="form-group">
        <div class="input-group">
            <input class="form-control" type="text" name="{{@$query}}" value="{{@$search}}"
                autocomplete="off" placeholder="{{ $txtSearch or trans('gitscrum.search') }}">
            <span class="input-group-btn">
                <button class="btn btn-default" type="submit">{{trans('gitscrum.search')}}!</button>
            </span>
        </div>
    </div>
    </form>


    <a href="{{@$route}}" class="btn btn-default pull-left"><i class="fa fa-refresh"></i> {{trans('gitscrum.refresh')}}</a>

    <div class="clearfix"></div>

</div>

@if ( @$search )
<p class="alert alert-success">{{trans('gitscrum.search-by')}} <strong>{{$search}}</strong></p>
@endif
