<!-- Task Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('task_id', 'Task Id:') !!}
    {!! Form::text('task_id', (!Request::is('tasktypeEavValues/create')) ? $tasktypeEavValue->task_id : null, ['class' => 'form-control']) !!}
</div>

<!-- Task Type Eav Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('task_type_eav_id', 'Task Type Eav Id:') !!}
    {!! Form::text('task_type_eav_id', (!Request::is('tasktypeEavValues/create')) ? $tasktypeEavValue->task_type_eav_id : null, ['class' => 'form-control']) !!}
</div>

<!-- Task Value Field -->
<div class="form-group col-sm-6">
    {!! Form::label('task_value', 'Task Value:') !!}
    {!! Form::text('task_value', (!Request::is('tasktypeEavValues/create')) ? $tasktypeEavValue->task_value : null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tasktypeEavValues.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>
