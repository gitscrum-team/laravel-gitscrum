<div class="burndown">
    @if(isset($title))
    <h4 class="gs-card-title">{{$title or trans('gitscrum.burndown')}}</h4>
    @endif
    <div class="gs-card-content">
        <div class="row">
            <canvas id="burndown" height="{{$height or '320'}}" class="col-md-12"></canvas>
        </div>
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
            backgroundColor: "rgba(161,163,166,0.2)",
            borderColor: "rgba(161,163,166,0.6)",
            pointBorderColor: "rgba(161,163,166,1)",
            pointBackgroundColor: "rgba(161,163,166,0.5)",
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
