<!-- Type Field -->
{!! Form::hidden('tasktype_id', $task->tasktype_id) !!}

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', $task->title, ['class' => 'form-control','required']) !!}
</div>

<!-- Taskstatus Field -->
<div class="form-group col-sm-2">
    {!! Form::label('taskstatus_id', 'Taskstatus:') !!}
    {!! Form::select('taskstatus_id',$selectTaskstatus ,$task->taskstatus_id, ['class' => 'form-control','required']) !!}
</div>

<!-- End At Field -->
<div class="form-group col-sm-2">
    {!! Form::label('end_at', 'End At:') !!}
    {!! Form::text('end_at',$task->end_at ? $task->end_at : date('Y-m-d H:i:s'), ['class' => 'form-control','required','data-inputmask'=>"'alias': 'yyyy-mm-dd hh:mm:ss'"]) !!}
</div>

<!-- Hours Field -->
<div class="form-group col-sm-2">
    {!! Form::label('hours', 'Hours:') !!}
    {!! Form::text('hours', $task->hours, ['class' => 'form-control','required','data-inputmask'=>'"mask": "9.9"']) !!}
</div>

{{--<!-- // Informed Field 相关邮件提醒功能-->--}}
<?php $informedlist=($task->informedlist); ?>
<div class="form-group col-sm-6">
    {!! Form::label('informed', 'informed:') !!}
    {!! Form::select('informed[]',$informedlist, $task->informed, ['class' => 'form-control select2-ajax-users','multiple'=>'multiple']) !!}
</div>

<div class="form-group col-sm-6 optionally">
    {!! Form::label('product_id', 'product_id:') !!}
    {!! Form::select('product_id',[$task->product_id=>$task->product_name], $task->product_id, ['class' => 'form-control select2-ajax-products']) !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('project_id', 'project_id:') !!}
    {!! Form::select('project_id',[$task->project_id=>$task->project_name], $task->project_id, ['class' => 'form-control select2-ajax-projects']) !!}
</div>
@section('scripts')
    <script type="text/javascript">
        select2(".select2-ajax-users","/tasks/usersajaxlist");
        select2(".select2-ajax-projects","/tasks/projectsajaxlist");
        select2(".select2-ajax-products","/tasks/productajax");
    </script>
@endsection

@include('tasks.eav_fields')

<div class="form-group col-sm-12">
    {!! Form::label('content', 'Content:') !!}
    <textarea id="content" name="content">{{ $task->content }}</textarea>
    <script type="text/javascript">
        var ue = UE.getEditor('content');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tasks.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>

{{--<div class="form-group col-sm-6">--}}
{{--{!! Form::label('tasktype_id', 'Tasktype:') !!}--}}
{{--{!! Form::select('tasktype_id',array_column(\App\Models\Tasktype::all('name','id')->toArray(),'name','id') ,--}}
{{--(!Request::is('tasks/create*')) ? $task->tasktype()->getResults()->id : null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

{{--@section('scripts')--}}
    {{--<script type="text/javascript">--}}
        {{--$( "#tasktype_id" ).change(function() { alert( "Handler for .change() called." + $('#tasktype_id option:selected').val()); });--}}
        {{--$(document).ready(function() { $(".select2-basic-single").select2({theme: "bootstrap"});  });--}}
    {{--</script>--}}
{{--@endsection--}}