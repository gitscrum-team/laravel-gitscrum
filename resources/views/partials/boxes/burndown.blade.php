<div class="burndown">
    @if(isset($title))
    <h4>{{$title or trans('gitscrum.burndown')}}</h4>
    @endif
    <div class="row">
        <canvas id="burndown" height="{{$height or '320'}}" class="col-md-12"></canvas>
    </div>
</div>


<script>
$(function() {

    var burndown = $("#burndown");

    var data = {
    labels: [ @foreach($list as $key=>$value) '{{$key}}', @endforeach ],
    datasets: [
        {
            label: "Issues",
            fill: true,
            lineTension: 0,
            backgroundColor: "rgba(219,68,83,0.4)",
            borderColor: "rgba(219,68,83,1)",
            pointBorderColor: "rgba(219,68,83,1)",
            pointBackgroundColor: "rgba(219,68,83,1)",
            pointBorderWidth: 1,
            pointHoverRadius: 6,
            pointRadius: 6,
            pointHitRadius: 2,
            data: [ @foreach($list as $key=>$value) '{{$value}}', @endforeach  ,0],
            spanGaps: false,
        }
    ]};

    var chartLine = new Chart(burndown, {
        type: 'line',
        data: data,
        options: {
            responsive: false,
            scales: {
                yAxes: [{
                    ticks: {
                        display: false
                    }
                }],
                xAxes: [{
                    ticks: {
                        display: false
                    }
                }]
            }
        }
    });

});

</script>
