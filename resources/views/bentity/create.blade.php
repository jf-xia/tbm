
@extends('layouts.app')


@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            新增业务库配置
        </h1>
        {{--<div>{{$bentity}}</div>--}}

    </section>

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'bentity.store']) !!}
                    <div class="form-group col-sm-6">
                        {!! Form::label('name', '业务库名称:') !!}
                        {!! Form::input("text","name",null, ['class' => 'form-control select2-ajax-projects','required']) !!}
                    </div>


                    <div class="form-group col-sm-6">
                        {!! Form::label('tasktypes_id', '任务类型:') !!}
                        {!! Form::select('tasktypes_id',$tasktype, null, ['class' => 'form-control select2-ajax-projects','required']) !!}
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::label('context', '详情:') !!}
                        {!! Form::textarea("context",null,['class' => 'form-control select2-ajax-projects']) !!}
                    </div>

                    <div class="form-group col-sm-12">
                        {!! Form::submit('保存', ['class' => 'btn btn-primary']) !!}
                        <a href="{!!route("bentity.index") !!}" class="btn btn-default"> 取消</a>
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
























{{--@section('content')--}}
    {{--<section class="content-header">--}}
        {{--<h1>--}}
            {{--新增业务库配置--}}
        {{--</h1>--}}
        {{--<div>{{$bentity}}</div>--}}

    {{--</section>--}}

    {{--<div class="content">--}}
        {{--@include('adminlte-templates::common.errors')--}}
        {{--<div class="box box-primary">--}}

            {{--<div class="box-body">--}}
                {{--<div class="row">--}}
                    {{--{!! Form::open(['route' => 'benattrset.store']) !!}--}}
                       {{--<div class="form-group col-sm-6">--}}
                            {{--{!! Form::label('bentity_id', '名称:') !!}--}}
                           {{--<input class="form-control" type="text" name="name" id="name" required>--}}


                    {{--<div class="form-group col-sm-6">--}}
                        {{--{!! Form::label('tasktypes_id', '任务类型:') !!}--}}
                        {{--{!! Form::select('tasktypes_id',$tasktype, null, ['class' => 'form-control select2-ajax-projects','required']) !!}--}}
                    {{--</div>--}}
                   {{--<div class="form-group col-sm-12">--}}
                       {{--{!! Form::label('context', '详情:') !!}--}}
                       {{--{!! Form::textarea('context', null, ['class' => 'form-control select2-ajax-projects','required']) !!}--}}
                       {{--<textarea class="form-control" type="text" name="context" id="context" ></textarea>--}}
                    {{--</div>--}}
                    {{--<div class="form-group col-sm-12">--}}
                        {{--{!! Form::submit('保存', ['class' => 'btn btn-primary','style'=>'float:right']) !!}--}}
                    {{--</div>--}}
                    {{--{!! Form::close() !!}--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}


