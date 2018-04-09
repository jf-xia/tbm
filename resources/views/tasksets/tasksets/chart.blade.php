@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="{{ URL::asset('vendor/daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">@lang('view.Reports')@lang('view.Statistics')</h1>
        <h1 class="pull-right">
            <div class="form-group">
                <div class="input-group">
                    {!! Form::open(['route' => 'reports.chart','method'=>'get','id'=>'datepicker']) !!}
                    {!! Form::hidden('from', $input['from'], ['id'=>'from']) !!}
                    {!! Form::hidden('to', $input['to'], ['id'=>'to']) !!}
                    {!! Form::close() !!}
                    <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span>
                      <i class="fa fa-calendar"></i> {{ date('Y/m/d',strtotime($input['from'])) }}  -  {{ date('Y/m/d',strtotime($input['to'])) }}
                        {{--@lang('view.Date range picker')--}}
                    </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div>
            </div>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body" id="reportsStatistics">
                @foreach($reportsStatistics as $idkey=>$report)
                    @if($report['taskTypes'])
                        <?php $idkeyA=explode('_',$idkey) ?>
                        <h3>{!! isset($idkeyA[1]) ? $myTeams[$idkeyA[1]] : '' !!}@lang('view.'.$idkeyA[0])</h3>
                        {!! isset($report['table']) ? $report['table'] : '' !!}
                        <canvas id="{{ $idkey }}" height="{{ count($report['taskTypes'])*10+30 }}"></canvas>
                    @endif
                @endforeach
                <h3>@lang('view.Monthly trend analysis')</h3>
                {!! $taskMonthAnalyic !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/daterangepicker/daterangepicker.js') }}"></script>

    <script type="text/javascript">

        window.chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            blueDone: 'rgb(36, 123, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(231,233,237)'
        };

        var color = Chart.helpers.color;

        var option = {
            scales: {
                xAxes: [{
                    stacked: true
                }],
                yAxes: [{
                    stacked: true
                }]
            },
            maintainAspectRatio: true,
            responsive: true,
            legend: {
                position: 'top',
            }
        };
        @include('reports.js_chart')

        $(function () {
            $('#daterange-btn').daterangepicker(
                {
                    startDate: moment('{{ ($input['from']) }}'), endDate: moment('{{ ($input['to']) }}'),
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    }
                },
                function (start, end) {
                    $('#daterange-btn span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
                    $('#from').val(start.format('YYYY-MM-DD HH:mm:ss'));
                    $('#to').val(end.format('YYYY-MM-DD HH:mm:ss'));
                    $("#datepicker").submit();
                }
            );
        });
    </script>
@endsection
