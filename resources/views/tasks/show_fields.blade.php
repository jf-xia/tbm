<!-- Title Field -->
<div class="form-group col-sm-6 widget">
    <h5 class="wlabel"><b>@lang('db.title')</b></h5>
    <h5 class="wvalue">{!! $task->title !!}</h5>
</div>

<!-- User Id Field -->
<div class="form-group col-sm-2 widget">
    <h5 class="wlabel"><b>@lang('db.user_id')</b></h5>
    <h5 class="wvalue">{!! $task->user->name !!}</h5>
</div>

<!-- Taskstatus Id Field -->
<div class="form-group col-sm-2 widget">
    <h5 class="wlabel"><b>@lang('db.taskstatus_id')</b></h5>
    <h5 class="wvalue">{!! $task->taskstatus_name !!}</h5>
</div>

<!-- Hours Field -->
<div class="form-group col-sm-2 widget">
    <h5 class="wlabel"><b>@lang('db.hours')</b></h5>
    <h5 class="wvalue">{!! $task->hours !!}</h5>
</div>

<!-- Tasktype Id Field -->
<div class="form-group col-sm-3 widget">
    <h5 class="wlabel"><b>@lang('db.tasktype_id')</b></h5>
    <h5 class="wvalue">{!! $task->tasktype_name !!}</h5>
</div>

<!-- Created At Field -->
<div class="form-group col-sm-3 widget">
    <h5 class="wlabel"><b>@lang('db.created_at')</b></h5>
    <h5 class="wvalue">{!! $task->created_at !!}</h5>
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-3 widget">
    <h5 class="wlabel"><b>@lang('db.updated_at')</b></h5>
    <h5 class="wvalue">{!! $task->updated_at !!}</h5>
</div>

<!-- End At Field -->
<div class="form-group col-sm-3 widget">
    <h5 class="wlabel"><b>@lang('db.end_at')</b></h5>
    <h5 class="wvalue">{!! $task->end_at !!}</h5>
</div>

<!-- Informed Field -->
<div class="form-group col-sm-4 widget">
    <h5 class="wlabel"><b>@lang('db.informed')</b></h5>
    <h5 class="wvalue">{!! implode(', ',$task->informedlist) !!}</h5>
</div>

<!-- Project Id Field -->
<div class="form-group col-sm-4 widget">
    <h5 class="wlabel"><b>@lang('db.project_id')</b></h5>
    <h5 class="wvalue">{!! $task->project_name !!}</h5>
</div>

<!-- product Id Field -->
<div class="form-group col-sm-4 widget">
    <h5 class="wlabel"><b>@lang('db.product_id')</b></h5>
    <h5 class="wvalue">{!! $task->product_name !!}</h5>
</div>

@include('tasks.eav_show_fields')