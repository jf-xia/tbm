<!-- Id Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('id', 'Id:') !!}</b></h5>
    <h5 class="wvalue">{!! $tasktype->id !!}</h5>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('name', 'Name:') !!}</b></h5>
    <h5 class="wvalue">{!! $tasktype->name !!}</h5>
</div>

<!-- Color Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('color', 'Color:') !!}</b></h5>
    <h5 class="wvalue">{!! $tasktype->color !!}</h5>
</div>

<!-- Assigned To Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('assigned_to', 'Assigned To:') !!}</b></h5>
    <h5 class="wvalue">{!! $tasktype->assignedto ? $tasktype->assignedto->name : '' !!}</h5>
</div>

<!-- tasktype_name Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('tasktype_name', 'tasktype_name:') !!}</b></h5>
    <h5 class="wvalue">{!! $tasktype->tasktype_name !!}</h5>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('created_at', 'Created At:') !!}</b></h5>
    <h5 class="wvalue">{!! $tasktype->created_at !!}</h5>
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('updated_at', 'Updated At:') !!}</b></h5>
    <h5 class="wvalue">{!! $tasktype->updated_at !!}</h5>
</div>

