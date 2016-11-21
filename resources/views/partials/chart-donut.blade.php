<div id="morris-donut-chart" style="height: 230px;"></div>

<script>
$(function(){
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
            @foreach ($list as $key => $status)
                { label: "{{$key}}", value: {{$status->count()}} },
            @endforeach
        ],
        resize: true,
        colors: [
            @foreach ($list as $status)
            '#{{$status->first()->color}}',
            @endforeach
        ],
    });
});
</script>
