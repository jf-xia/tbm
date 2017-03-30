@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Edit User
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">


                    {!! Form::model($user, ['route' => ['users.update', $user->id], 'method' => 'PATCH']) !!}

                    <div class="form-group col-sm-6">
                        {!! Form::label('name', 'name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control','required' => 'required']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('email', 'Email') !!}
                        {!! Form::email('email', null, ['class' => 'form-control','required' => 'required']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('password', 'Password') !!}
                        {!! Form::password('password', ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6">
                        {!! Form::label('password_confirmation', 'Password confirmation') !!}
                        {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                    </div>

                    @if($auth->isAdmin())
                            <!-- leader  Field -->
                        <div class="form-group col-sm-6">
                            {!! Form::label('leader', 'leader:') !!}
                            {!! Form::select('leader', [$user->leader=>$user->leader_name],  $user->leader, ['class' => 'form-control select2-ajax-users','required'=>'required']) !!}
                        </div>
                        @section('scripts')
                            <script type="text/javascript">
                                select2(".select2-ajax-users", "/tasks/usersajaxlist");
                            </script>
                        @endsection

                        <div class="form-group col-sm-6">
                            @lang('db.role')
                            @foreach($roles as $role)
                                <?php $checked = $userRoles->get()->contains($role->id); ?>
                                    <div class="checkbox">
                                        <label>
                                            {!! Form::checkbox('role[]', $role->id, $checked) !!} {{ $role->display_name }}
                                        </label>
                                    </div>
                            @endforeach
                        </div>
                    @else
                        {!! Form::hidden('leader', $auth->id) !!}
                        @foreach($roles as $role)
                            @if($userRoles->get()->contains($role->id))
                                {!! Form::hidden('role[]', $role->id) !!}
                            @endif
                        @endforeach
                    @endif

                    <div class="form-group col-sm-6">
                        {!! Form::submit(trans('view.Update'), ['class' => 'btn btn-primary']) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
