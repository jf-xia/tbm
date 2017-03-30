
<div class="input-group col-sm-12" id="comment">
    {!! Form::textarea('comment', $taskgroup->comment, ['id'=>'comment'.$taskgroup->id,'required'=>'required','class' => 'form-control','rows'=>'3','placeholder'=>trans('view.Your suggestions or comments will make better work!')]) !!}
    <span class="input-group-addon btn btn-primary" onclick="javascript:comment({{ $taskgroup->id }},1)" ><h3><span class="glyphicon glyphicon-thumbs-up" ></span> @lang('view.Good')<span class="badge bg-green">{{ ($taskgroup->gradegood) }}</span></h3></span>
    <span class="input-group-addon btn btn-warning" onclick="javascript:comment({{ $taskgroup->id }},2)" ><h3><span class="glyphicon glyphicon-thumbs-down" ></span> @lang('view.Bad')<span class="badge bg-yellow">{{ ($taskgroup->gradebad) }}</span></h3></span>
</div>

@include('tasks.eav_show_fields')
