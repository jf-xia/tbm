@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Permissions</h1>
        <h1 class="pull-right">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!! route('permissions.create') !!}">Add New</a>
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
                        <th>Route</th>
                        <th>OrderBy</th>
                        <th colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->display_name }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->route }}</td>
                            <td>{{ $permission->orderby }}</td>
                            <td width="80"><a class="btn btn-primary" href="{{ URL::route('permissions.edit', $permission->id) }}">Edit</a></td>
                            <td width="80">{!! Form::open(['route' => ['permissions.update', $permission->id], 'method' => 'DELETE']) !!}
                                {!! Form::submit('Delete', ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");']) !!}
                                {!!  Form::close() !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $permissions->render() !!}

            </div>
        </div>
    </div>
@endsection

