@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('view.edit')@lang('view.Tasktype Eav')
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tasktypeEav, ['route' => ['tasktypeEavs.update', $tasktypeEav->id], 'method' => 'patch']) !!}

                        @include('tasktype_eavs.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection