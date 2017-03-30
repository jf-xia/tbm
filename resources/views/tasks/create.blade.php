@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
          @lang('view.create')@lang('view.Task') - {{ $tasktype->name }}
            <a href="{{ route('tasks.importByTypeId',$tasktype->id) }}" class="btn btn-default">@lang('view.Import')</a>
            <a href="{!! route('tasks.index') !!}" class="btn btn-default">@lang('view.Back')</a>
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'tasks.store']) !!}

                        @include('tasks.cfields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
