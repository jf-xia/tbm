@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Project
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($project, ['route' => ['projects.update', $project->id], 'method' => 'patch']) !!}

                        @include('projects.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection