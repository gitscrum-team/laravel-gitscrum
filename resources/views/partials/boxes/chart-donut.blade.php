@if( $list )
    @if( isset($title) )<h3>{{$title}}</h3>@endif
    @include('partials.chart-donut', ['list' => $list])
@endif
