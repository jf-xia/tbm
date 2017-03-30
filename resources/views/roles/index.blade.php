@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Roles</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('roles.create') !!}">Add New</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Display Name</th>
                        <th>Name</th>
                        <th>Level</th>
                        <th>Permissions</th>
                        <th colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->level }}</td>
                            <td>
                                @foreach($role->perms as $permission)
                                    <span class="label label-info">{{ $permission->name }}</span>
                                @endforeach
                            </td>
                            @if( $role->id != 1)
                                <td width="80"><a class="btn btn-primary" href="{{ URL::route('roles.edit', $role->id) }}">Edit</a></td>

                                <td width="80">{!! Form::open(['route' => ['roles.destroy', $role->id], 'method' => 'DELETE']) !!}
                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");']) !!}
                                    {!!  Form::close() !!}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $roles->render() !!}

            </div>
        </div>
    </div>
@endsection

