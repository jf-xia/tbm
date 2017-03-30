<!-- Keyname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('keyname', 'Keyname:') !!}
    {!! Form::text('keyname', (!Request::is('userresumes/create')) ? $userresume->keyname : null, ['class' => 'form-control']) !!}
</div>

<!-- Content Field -->
<div class="form-group col-sm-6">
    {!! Form::label('content', 'Content:') !!}
    {!! Form::text('content', (!Request::is('userresumes/create')) ? $userresume->content : null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', (!Request::is('userresumes/create')) ? $userresume->user_id : null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('userresumes.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>
