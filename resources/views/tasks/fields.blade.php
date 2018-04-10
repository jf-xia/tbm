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

@section('scripts')
    <script type="text/javascript">
        select2(".select2-ajax-users","/tasks/usersajaxlist");
    </script>
@endsection