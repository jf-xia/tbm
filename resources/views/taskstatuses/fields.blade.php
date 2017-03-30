
<!-- user_id Field -->
{!! Form::hidden('user_id',Auth::id()) !!}

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', (!Request::is('taskstatuses/create')) ? $taskstatus->name : null, ['class' => 'form-control']) !!}
</div>

<!-- Color Field -->
<div class="form-group col-sm-6">
    {!! Form::label('color', 'Color:') !!}
    {!! Form::color('color', (!Request::is('taskstatuses/create')) ? $taskstatus->color : null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('taskstatuses.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>
