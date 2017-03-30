@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('view.edit')@lang('view.Task') - {{ $task->tasktype_name }}
            <a href="{!! route('tasks.index') !!}" class="btn btn-default">@lang('view.Back')</a>
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($task, ['route' => ['tasks.update', $task->id], 'method' => 'patch']) !!}

                        @include('tasks.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
       @include('tasks.show_sub_fields')
   </div>
@endsection