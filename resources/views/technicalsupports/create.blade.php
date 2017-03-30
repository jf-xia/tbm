@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
          @lang('view.create')@lang('view.Technicalsupport')
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'technicalsupports.store']) !!}

                        @include('technicalsupports.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
