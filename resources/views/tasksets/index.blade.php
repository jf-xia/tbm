@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">{{ $tasktype?$tasktype->name:'' }}</h1>
        <h1 class="pull-right">
            @if($tasktype_id)
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{{ route('tasks.createByTypeId',$tasktype_id) }}">@lang('view.Add New')</a>
            @endif
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="form-group col-sm-5">

                </div>
                    @include('tasksets.table')
            </div>
        </div>
    </div>
@endsection
