
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
                    {!! Form::open(['route' => 'benattrset.store']) !!}
                       <div class="form-group col-sm-6">
                            {!! Form::label('bentity_id', '业务库名称:') !!}
                            {!! Form::select('bentity_id',$getBentityList, null, ['class' => 'form-control select2-ajax-projects','required']) !!}
                        </div>


                    <div class="form-group col-sm-6">
                        {!! Form::label('tasktypes_id', '任务类型:') !!}
                        {!! Form::select('tasktypes_id',$getTasktypeList, null, ['class' => 'form-control select2-ajax-projects','required']) !!}
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::submit('保存', ['class' => 'btn btn-primary','style'=>'float:right']) !!}
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
