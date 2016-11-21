<div class="m-b-md">
    <div class="btn-group pull-right">
        <form method="get" action="" class="pull-right mail-search">
            <div class="input-group">
                <input type="text" class="form-control input-sm" name="{{@$query}}" value="{{@$search}}"
                    autocomplete="off" placeholder="{{ $txtSearch or 'Search' }}">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-sm btn-primary">{{_('Search')}}</button>
                </div>
            </div>
        </form>
    </div>

    <a href="{{@$route}}" class="btn btn-white btn-sm pull-left"><i class="fa fa-refresh"></i> {{_('Refresh')}}</a>

    <div class="clearfix"></div>

</div>

@if ( @$search )
<p class="font-bold  alert alert-success m-b-sm">{{_('Search by')}} <strong>{{$search}}</strong></p>
@endif
