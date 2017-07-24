@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">@lang('view.Tasks')</h1>
        {{--我的任务列表新建--}}
        <h1 class="pull-right">
            <button class="btn btn-primary dropdown-toggle" style="margin-top: -10px;margin-bottom: 5px"  type="button" data-toggle="dropdown" >
                @lang('view.Add New')<span class="caret"></span>
            </button>
            <ul class="dropdown-menu" >
                @foreach($tasktype as $taskTypeId=>$taskTypeName)
                    <li><a href="{{ route('tasks.createByTypeId',$taskTypeId) }}">{{ $taskTypeName }}</a></li>
                @endforeach
            </ul>
        </h1>

    </section>
    <div class="content">
                <div class="clearfix"></div>

                @include('flash::message')

                <div class="clearfix"></div>
                <div class="box box-primary">
                    <div class="box-body">
                @include('tasks.table')
                    </div>
                </div>
    </div>
@endsection

