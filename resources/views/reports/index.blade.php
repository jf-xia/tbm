@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">@lang('view.Business')@lang('view.Reports')</h1>
        <h1 class="pull-right">
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group col-sm-5">
                    {{--@lang('view.Team Report:')--}}
                    {!! Form::select('tasktype_select',$tasktype,$tasktype_id, ['class' => 'form-control','onchange'=>"window.location.href='".url('reports/task')."/'+$(this).children('option:selected').val();"]) !!}
                </div>
                    @include('reports.table')
            </div>
        </div>
        {{--<div class="clearfix"></div>--}}
        {{--<div class="box box-primary">--}}
            {{--<div class="box-body">--}}
                {{--<div class="form-group col-sm-12">--}}
                    {{--<canvas id="monthChart" ></canvas>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection


{{--@section('scripts')--}}
    {{--<script src="{{ URL::asset('vendor/chartjs/Chart.bundle.min.js') }}"></script>--}}

    {{--<script type="text/javascript">--}}
        {{--var color = Chart.helpers.color;--}}

        {{--var monthChartData = {--}}
            {{--labels: {!! json_encode(($report['taskTypes'])) !!},--}}
            {{--datasets: [{--}}
                {{--label: '@lang('db.taskdone') @lang('view.Statistics')',--}}
                {{--backgroundColor: color('rgb(75, 192, 192)').alpha(0.5).rgbString(),--}}
                {{--borderColor: 'rgb(75, 192, 192)',--}}
                {{--borderWidth: 1,--}}
                {{--data: {!! json_encode(($report['taskCount'])) !!}--}}
            {{--}--}}
        {{--};--}}

        {{--var monthChart = document.getElementById("monthChart").getContext("2d");--}}
        {{--window.myBar = new Chart(monthChart, {--}}
            {{--type: 'line',--}}
            {{--data: monthChartData,--}}
            {{--options: {--}}
                {{--scales: {--}}
                    {{--xAxes: [{--}}
                        {{--stacked: true--}}
                    {{--}],--}}
                    {{--yAxes: [{--}}
                        {{--stacked: true--}}
                    {{--}]--}}
                {{--},--}}
                {{--maintainAspectRatio: true,--}}
                {{--responsive: true,--}}
                {{--legend: {--}}
                    {{--position: 'top',--}}
                {{--}--}}
            {{--}--}}
        {{--});--}}
    {{--</script>--}}
{{--@endsection--}}
