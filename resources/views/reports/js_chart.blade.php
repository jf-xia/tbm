@foreach($reportsStatistics as $idkey=>$report)
    <?php //report=$report[0]; ?>
    @if($report['taskTypes'])
        var {{ $idkey }}Data = {
            labels: {!! json_encode(($report['taskTypes'])) !!},
            datasets: [{
                label: '@lang('db.taskundo') @lang('view.Statistics')',
                backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
                borderColor: window.chartColors.red,
                borderWidth: 1,
                data: {!! json_encode(($report['taskCount'])) !!}
                },{
                label: '@lang('db.taskdone') @lang('view.Statistics')',
                backgroundColor: color(window.chartColors.blueDone).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: {!! json_encode(($report['taskdone'])) !!}
                },{
                label: '@lang('db.hours') @lang('view.Statistics')',
                backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
                borderColor: window.chartColors.blue,
                borderWidth: 1,
                data: {!! json_encode(($report['taskHourSum'])) !!}
                }
                {{--,{--}}
                    {{--label: '@lang('db.uncomment') @lang('view.Statistics')',--}}
                    {{--backgroundColor: color(window.chartColors.orange).alpha(0.5).rgbString(),--}}
                    {{--borderColor: window.chartColors.orange,--}}
                    {{--borderWidth: 1,--}}
                    {{--data: {!! json_encode(($report['taskUncommentSum'])) !!}--}}
                {{--},{--}}
                    {{--label: '@lang('db.good') @lang('view.Statistics')',--}}
                    {{--backgroundColor: color(window.chartColors.green).alpha(0.5).rgbString(),--}}
                    {{--borderColor: window.chartColors.green,--}}
                    {{--borderWidth: 1,--}}
                    {{--data: {!! json_encode(($report['taskGoodSum'])) !!}--}}
                {{--},{--}}
                    {{--label: '@lang('db.bad') @lang('view.Statistics')',--}}
                    {{--backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),--}}
                    {{--borderColor: window.chartColors.yellow,--}}
                    {{--borderWidth: 1,--}}
                    {{--data: {!! json_encode(($report['taskBadSum'])) !!}--}}
                {{--}--}}
                @if(isset($report['taskPriceSum']))
                ,{
                    label: '@lang('db.price') @lang('view.Statistics')',
                    backgroundColor: color(window.chartColors.purple).alpha(0.5).rgbString(),
                    borderColor: window.chartColors.purple,
                    borderWidth: 1,
                    data: {!! json_encode(($report['taskPriceSum'])) !!}
                }
                @endif
            ]
        };

        var {{ $idkey }} = document.getElementById("{{ $idkey }}").getContext("2d");
        window.myBar = new Chart({{ $idkey }}, {
            type: 'horizontalBar',
            data: {{ $idkey }}Data,
            options: option
        });
    @endif
@endforeach