<!-- Id Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('id', 'Id:') !!}</b></h5>
    <h5 class="wvalue">{!! $report->id !!}</h5>
</div>

<!-- Name Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('name', 'Name:') !!}</b></h5>
    <h5 class="wvalue">{!! $report->name !!}</h5>
</div>

<!-- Desc Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('desc', 'Desc:') !!}</b></h5>
    <h5 class="wvalue">{!! $report->desc !!}</h5>
</div>

<!-- Rules Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('rules', 'Rules:') !!}</b></h5>
    <h5 class="wvalue">{!! $report->rules !!}</h5>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('created_at', 'Created At:') !!}</b></h5>
    <h5 class="wvalue">{!! $report->created_at !!}</h5>
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>{!! Form::label('updated_at', 'Updated At:') !!}</b></h5>
    <h5 class="wvalue">{!! $report->updated_at !!}</h5>
</div>

