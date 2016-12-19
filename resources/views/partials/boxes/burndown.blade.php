<div style="">
    <h4 class="lead mbn pbn">{{$title}} {{trans('Burndown')}}</h4>
    <div class="row">
        <canvas id="burndown" height="320" class="col-md-12"></canvas>
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
            height: 230,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 1,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [ @foreach($list as $key=>$value) '{{$value}}', @endforeach ],
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
