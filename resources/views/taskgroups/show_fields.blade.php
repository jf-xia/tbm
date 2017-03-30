<!-- Id Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('id', 'Id:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskgroup->id !!}</h5>
</div>

<!-- Task Id Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('task_id', 'Task Id:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskgroup->task_id !!}</h5>
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('user_id', 'User Id:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskgroup->user_id !!}</h5>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('created_at', 'Created At:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskgroup->created_at !!}</h5>
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('updated_at', 'Updated At:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskgroup->updated_at !!}</h5>
</div>

