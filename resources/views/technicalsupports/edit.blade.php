@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('view.edit')@lang('view.Technicalsupport')
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($technicalsupport, ['route' => ['technicalsupports.update', $technicalsupport->id], 'method' => 'patch']) !!}

                        @include('technicalsupports.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection