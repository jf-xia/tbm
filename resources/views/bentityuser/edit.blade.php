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


                    {!! Form::model($bentityuser, ['route' => ['benuser.update', $bentityuser->id], 'method' => 'PATCH']) !!}


                    <div class="form-group col-sm-6">
                        {!! Form::label('user_id', '用户姓名:') !!}
                        {{--{!! Form::select('user_id',$getUserList, null, ['class' => 'form-control select2-ajax-projects','required']) !!}--}}
                        {!! Form::select('user_id',$getUserList, null, ['class' => 'form-control select2-ajax-users','multiple'=>'multiple']) !!}
                    </div>


                    <div class="form-group col-sm-6">
                        {!! Form::label('tasktypes_id', '任务类型:') !!}
                        {!! Form::select('tasktypes_id',$getTasktypeList, null, ['class' => 'form-control select2-ajax-projects','required']) !!}
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
@section('scripts')
    <script type="text/javascript">
        select2(".select2-ajax-users","/tasks/usersajaxlist");

    </script>
@endsection