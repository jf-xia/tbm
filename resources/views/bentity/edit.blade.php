@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           业务库配置修改
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">


                    {!! Form::model($ben, ['route' => ['bentity.update', $ben->id], 'method' => 'PATCH']) !!}
                    <div class="form-group col-sm-6">
                        {!! Form::label('name', '业务库名称:') !!}
                        {!! Form::input("text","name",$ben->name, ['class' => 'form-control select2-ajax-projects','required']) !!}
                    </div>


                    <div class="form-group col-sm-6">
                        {!! Form::label('tasktypes_id', '任务类型:') !!}
                        {!! Form::select('tasktypes_id',$tasktype, null, ['class' => 'form-control select2-ajax-projects','required']) !!}
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::label('context', '详情:') !!}
                        {!! Form::textarea("context",$ben->context,['class' => 'form-control select2-ajax-projects']) !!}
                    </div>

                    <div class="form-group col-sm-12">
                        {!! Form::submit('修改', ['class' => 'btn btn-primary']) !!}
                        <a href="{!!route("bentity.index") !!}" class="btn btn-default"> 取消</a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
