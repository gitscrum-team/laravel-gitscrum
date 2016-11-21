@section('title',  _('Profile') . ' - ' . $user->username)

@extends('layouts.master')

@section('breadcrumb')

<div class="page-heading">
    <div class="col-lg-6">
        <h2>{{_('User Profile')}}</h2>
    </div>
</div>

@endsection

@section('content')

<div class="row">

    <div class="col-lg-4">

        <div class="ibox">

            <div class="ibox-content">

            @include('partials.header-user', ['user' => $user])

            </div>

        </div>

    </div>

    <div class="col-lg-8">

        <div class="ibox">

            <div class="ibox-content">

                <div class="col-lg-3">
                    <h5>{{_('Effort')}}</h5>
                    <h2>65 000</h2>
                    <div id="sparkline1"></div>
                </div>

                <div class="col-lg-3">
                    <h5>{{_('Cooperation')}}</h5>
                    <h2>65 000</h2>
                    <div id="sparkline4"></div>
                </div>

                <div class="col-lg-3">
                    <h5>{{_('Issue Done')}}</h5>
                    <h2>65 000</h2>
                    <div id="sparkline2"></div>
                </div>

                <div class="col-lg-3">
                    <h5>{{_('Commits')}}</h5>
                    <h2>65 000</h2>
                    <div id="sparkline3"></div>
                </div>

                <div class="clearfix"></div>

            </div>

        </div>

    </div>

</div>

<script>
        $(document).ready(function() {

            var sparklineCharts = function(){
                 $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 52], {
                     type: 'line',
                     width: '100%',
                     height: '60',
                     lineColor: '#1ab394',
                     fillColor: "#ffffff"
                 });

                 $("#sparkline2").sparkline([24, 43, 43, 55, 44, 62, 44, 72], {
                     type: 'line',
                     width: '100%',
                     height: '60',
                     lineColor: '#1ab394',
                     fillColor: "#ffffff"
                 });

                 $("#sparkline3").sparkline([74, 43, 23, 55, 54, 32, 24, 12], {
                     type: 'line',
                     width: '100%',
                     height: '60',
                     lineColor: '#1ab394',
                     fillColor: "#ffffff"
                 });

                 $("#sparkline4").sparkline([24, 43, 33, 55, 64, 72, 44, 22], {
                     type: 'line',
                     width: '100%',
                     height: '60',
                     lineColor: '#1ab394',
                     fillColor: "#ffffff"
                 });
            };

            var sparkResize;

            $(window).resize(function(e) {
                clearTimeout(sparkResize);
                sparkResize = setTimeout(sparklineCharts, 500);
            });

            sparklineCharts();


        });
    </script>

<script>
$(function(){
    var radarData = {
        labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling", "Running"],
        datasets: [
            {
                label: "My First dataset",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [65, 59, 90, 81, 56, 55, 40]
            },
            {
                label: "My Second dataset",
                fillColor: "rgba(26,179,148,0.2)",
                strokeColor: "rgba(26,179,148,1)",
                pointColor: "rgba(26,179,148,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(151,187,205,1)",
                data: [28, 48, 40, 19, 96, 27, 100]
            }
        ]
    };

    var radarOptions = {
        scaleShowLine: true,
        angleShowLineOut: true,
        scaleShowLabels: false,
        scaleBeginAtZero: true,
        angleLineColor: "rgba(0,0,0,.1)",
        angleLineWidth: 1,
        pointLabelFontFamily: "'Arial'",
        pointLabelFontStyle: "normal",
        pointLabelFontSize: 10,
        pointLabelFontColor: "#666",
        pointDot: true,
        pointDotRadius: 3,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        responsive: true,
    }

    var ctx = document.getElementById("radarChart").getContext("2d");
    var myNewChart = new Chart(ctx).Radar(radarData, radarOptions);

});
</script>

@endsection
