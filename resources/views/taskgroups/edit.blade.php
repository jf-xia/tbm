@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('view.edit')@lang('view.Taskgroup')
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($taskgroup, ['route' => ['taskgroups.update', $taskgroup->id], 'method' => 'patch']) !!}

                        @include('taskgroups.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection