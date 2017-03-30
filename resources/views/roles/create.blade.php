@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Create roles
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">

                    {!! Form::open(['route' => 'roles.store']) !!}

                    <div class="form-group col-sm-6">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('display_name', 'Display name') !!}
                        {!! Form::text('display_name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('description', 'Description') !!}
                        {!! Form::text('description', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('level', 'Level') !!}
                        {!! Form::number('level', null, ['class' => 'form-control', 'min' => '0']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="">Permissions</label>
                        @foreach($permissions->sortBy('orderby') as $permission)
                            <div class="checkbox">
                                <label>
                                    @if($permission->route<>'break')
                                    {!! Form::checkbox('perms[]', $permission->id) !!}
                                    @endif
                                    {{ $permission->display_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
