<!-- Id Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('id', 'Id:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskcomment->id !!}</h5>
</div>

<!-- Task Id Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('task_id', 'Task Id:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskcomment->task_id !!}</h5>
</div>

<!-- Grade Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('grade', 'Grade:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskcomment->grade !!}</h5>
</div>

<!-- Comment Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('comment', 'Comment:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskcomment->comment !!}</h5>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('created_at', 'Created At:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskcomment->created_at !!}</h5>
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('updated_at', 'Updated At:') !!}</b></h5>
    <h5 class="wvalue">{!! $taskcomment->updated_at !!}</h5>
</div>

