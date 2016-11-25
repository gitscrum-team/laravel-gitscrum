@if( $list )
    @if( isset($title) )<h3>{{$title}}</h3>@endif

    <div class="mtm ptm">
        <canvas id="polarChart" height="380" class="col-md-12"></canvas>
    </div>

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

    var data = {
        datasets: [{
            data: [ @foreach ($list as $key => $status) '{{$status->count()}}', @endforeach ],
            backgroundColor: [ @foreach ($list as $status) '#{{$status->first()->color}}', @endforeach ],
            label: 'Progress'
        }],
        labels: [ @foreach ($list as $key => $status) '{{$key}}', @endforeach ]
    };

    var polarChart = $("#polarChart");

    new Chart(polarChart, {
        data: data,
        type: 'polarArea',
    });
    </script>

@endif
