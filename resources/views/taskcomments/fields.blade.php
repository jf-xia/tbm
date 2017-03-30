<!-- Task Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('task_id', 'Task Id:') !!}
    {!! Form::text('task_id', (!Request::is('taskcomments/create')) ? $taskcomment->task_id : null, ['class' => 'form-control']) !!}
</div>

<!-- Grade Field -->
<div class="form-group col-sm-12">
    {!! Form::label('grade', 'Grade:') !!}
    <label class="radio-inline">
        {!! Form::radio('grade', "1", null) !!} Good
    </label>

    <label class="radio-inline">
        {!! Form::radio('grade', "2", null) !!} Bad
    </label>

</div>

<div class="form-group col-sm-12">
    {!! Form::label('comment', 'Comment:') !!}
    <textarea id="comment" name="comment">{{ (!Request::is('taskcomments/create')) ? $taskcomment->comment : null }}</textarea>
    <script type="text/javascript">
    //jack-2016-10-25
        var ue = UE.getEditor('comment');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('taskcomments.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>
