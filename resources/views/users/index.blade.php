@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Users</h1>
        <h1 class="pull-right"  style="margin-top: -10px;margin-bottom: 5px">
            <a class="btn btn-primary pull-right" href="{!! route('users.create') !!}">@lang('view.Add New')</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">

                <div class="input-group col-sm-3">
                    {!! Form::text('searchemail',isset(Request::all()['search']) ? Request::all()['search']:'',['id'=>'searchemail','class'=>'form-control','placeholder'=>'E-mail']) !!}
                    <span class="input-group-btn" onclick="javascript:if($('#searchemail').val()!==''){window.location.href='{{ route('users.index') }}?search='+$('#searchemail').val();}">
                        <button class="btn btn-default" type="button">@lang('view.Search')</button></span>
                    <span class="input-group-btn" onclick="javascript:window.location.href='{!! route('users.index') !!}'">
                        <button class="btn btn-default" type="button">@lang('view.Reset')</button></span>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>@lang('db.name')</th>
                        <th>@lang('db.email')</th>
                        <th>@lang('db.role')</th>
                        <th>@lang('db.leader')</th>
                        <th colspan="2"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="label label-info">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>{{ $user->leader_name }}</td>
                            <td width="80"><a class="btn btn-primary" href="{{ URL::route('users.edit', $user->id) }}">@lang('view.edit')</a></td>
                            <td width="80">{!! Form::open(['route' => ['users.update', $user->id], 'method' => 'DELETE']) !!}
                                    {!! Form::submit(trans('view.Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");']) !!}
                                {!!  Form::close() !!}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                {!! $users->render() !!}

            </div>
        </div>
    </div>
@endsection

