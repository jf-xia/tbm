@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('view.edit')@lang('view.Userresume')
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($userresume, ['route' => ['userresumes.update', $userresume->id], 'method' => 'patch']) !!}

                        @include('userresumes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection