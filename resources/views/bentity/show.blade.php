@extends('layouts.app')
<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
{{--@section('css')--}}
    {{--@include('layouts.datatables_css')--}}
{{--@endsection--}}

{{--{!! $dataTable->table(['width' => '100%']) !!}--}}
@section('content')
<section class="content-header">
    <h1 class="pull-left">
        {{--业务详情--}}
{{--        - {{ $task->tasktype_name }}--}}
    </h1>
    <div class="clearfix"></div>
</section>
<div class="content">
    @include('flash::message')
    @include('bentity.show_sub_fields')
</div>
@endsection
