@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Edit roles
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">


                    {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PATCH']) !!}

                    <div class="form-group col-sm-6">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control','readonly' => 'readonly']) !!}
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
                        {!! Form::text('level', null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
                        {!! Form::hidden('level', $role->level) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        <label for="">Permissions</label>
                        @foreach($permissions->sortBy('orderby') as $permission)
                            <?php $checked = $rolePerms->get()->contains($permission->id); ?>
                                <div class="checkbox">
                                    <label>
                                        @if($permission->route<>'break')
                                        {!! Form::checkbox('perms[]', $permission->id, $checked) !!}
                                        @endif
                                        {{ $permission->display_name }}
                                    </label>
                                </div>
                        @endforeach
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
