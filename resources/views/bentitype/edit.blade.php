@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
           编辑业务库类型
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">


                    {!! Form::model($bentitype, ['route' => ['bentitype.update', $bentitype->id], 'method' => 'PATCH']) !!}

                    <div class="form-group col-sm-6">
                        {!! Form::label('name', '名称') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('context', '详情') !!}
                        {!! Form::text('context', null, ['class' => 'form-control']) !!}
                    </div>
                    <div class="form-group col-sm-12">
                        {!! Form::submit('修改', ['class' => 'btn btn-primary','style'=>'float:right']) !!}
                    </div>
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endsection
