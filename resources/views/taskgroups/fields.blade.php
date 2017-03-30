<!-- Task Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('task_id', 'Task Id:') !!}
    {!! Form::text('task_id', (!Request::is('taskgroups/create')) ? $taskgroup->task_id : null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', (!Request::is('taskgroups/create')) ? $taskgroup->user_id : null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('taskgroups.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>
