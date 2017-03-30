@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Role Permission</h1>
        <h1 class="pull-right">

        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                {!! Form::open(['url' => '/role_permission']) !!}
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Route</th>
                        @foreach($roles as $role)
                            <th class="text-center">{{ $role->display_name }}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th colspan="{{ count($roles) }}">&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($permissions as $permission)
                        <tr>
                            <td width="150">{{ $permission->display_name }}</td>
{{--                            @if($permission->route<>'break')--}}
                            <td><small class="label label-info">{{ $permission->route }}</small></td>
                            @foreach ($roles as $role)
                                <td width="150" class="text-center">
                                    @if ($permission->hasRole($role->name) && $role->name == 'admin')
                                        <input type="checkbox" checked="checked" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}" disabled="disabled">
                                        <input type="hidden" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}">
                                    @elseif($permission->hasRole($role->name))
                                        <input type="checkbox" checked="checked" name="roles[{{ $role->id}}][permissions][]" value="{{ $permission->id }}">
                                    @else
                                        <input type="checkbox" name="roles[{{ $role->id }}][permissions][]" value="{{ $permission->id }}">
                                    @endif
                                </td>
                            @endforeach
                            {{--@endif--}}
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="form-group col-sm-6">
                    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection

