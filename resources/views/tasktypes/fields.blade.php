<!-- Name Field -->
<div class="form-group col-sm-4">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', (!Request::is('tasktypes/create')) ? $tasktype->name : null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- product_required Field -->
<div class="form-group col-sm-2">
    {!! Form::label('product_required', 'product_required:') !!}
    {!! Form::select('product_required', [0=>'No',1=>'Yes'],  null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- project_required Field -->
<div class="form-group col-sm-2">
    {!! Form::label('project_required', 'project_required:') !!}
    {!! Form::select('project_required', [0=>'No',1=>'Yes'],  null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- multi_assigned Field -->
<div class="form-group col-sm-2">
    {!! Form::label('multi_assigned', 'multi_assigned:') !!}
    {!! Form::select('multi_assigned', [0=>'No',1=>'Yes'],  null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Color Field -->
<div class="form-group col-sm-2">
    {!! Form::label('color', 'Color:') !!}
    {!! Form::color('color', (!Request::is('tasktypes/create')) ? $tasktype->color : null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Assigned To Field -->
<div class="form-group col-sm-8">
    {!! Form::label('tasktype_name', 'tasktype_name:') !!}
    {!! Form::select('tasktype_id[]',$taskTypeList, (!Request::is('tasktypes/create')) ? $tasktype->tasktype_ids : null, ['class' => 'form-control select2-tasktypes','multiple'=>'multiple','id'=>'tasktype_ids']) !!}
</div>
<div class="form-group col-sm-4">
    {!! Form::label('assigned_to', 'Assigned To:') !!}
    {!! Form::select('assigned_to',(!Request::is('tasktypes/create')) ? [$tasktype->assigned_to=>$tasktype->assignedtoName] : [],  null, ['class' => 'form-control select2-ajax-users']) !!}
</div>
{{--新增业务库类型选项 //huayan --}}
<div class="form-group col-sm-8">
    {!! Form::label('bentity_name', 'bentity_name:') !!}
    {{--bentity_id[]中bentity_id字段名称与数据库字段名称一致--}}
{{--   {{dd( $tasktype->bentity_id,explode('|',$tasktype->bentity_id))}}--}}
    {{--由于从数据库取到bentity_id数据是字符串，在select中不能显示字符串，应该为数组，所以要转化为数组--}}
    {!! Form::select('bentity_id[]',$bentityList,(!Request::is('tasktypes/create')) ? explode('|',$tasktype->bentity_id): null, ['class' => 'form-control select2-tasktypes','multiple'=>'multiple']) !!}
</div>
@section('scripts')
    <script type="text/javascript">
        select2(".select2-ajax-users", "/tasks/usersajaxlist");
        $(".select2-tasktypes").select2();
        //select2(".select2-ajax-tasktypes", "/tasks/tasktypesajaxlist");
    </script>
@endsection

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tasktypes.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>

