<!-- Type Field --><?php if (!isset($tasktype_id)) { $tasktype_id=$tasktypeEav->tasktype->id; }?>
{!! Form::hidden('tasktype_id',$tasktype_id) !!}

<!-- Code Field -->
{{--<div class="form-group col-sm-6">--}}
    {{--{!! Form::label('code', 'Code:') !!}--}}
    {{--{!! Form::text('code', (!Request::is('tasktypeEavs/create*')) ? $tasktypeEav->code : null, ['class' => 'form-control']) !!}--}}
{{--</div>--}}

<!-- Frontend Label Field -->
<div class="form-group col-sm-2">
    {!! Form::label('frontend_label', 'Frontend Label:') !!}
    {!! Form::text('frontend_label', (!Request::is('tasktypeEavs/create*')) ? $tasktypeEav->frontend_label : null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<?php
    $frontend_inputs=array(
            'text'=>trans('view.'.'text'),
            'date'=>trans('view.'.'date'),
            'select'=>trans('view.'.'select'),
            'email'=>trans('view.'.'email'),
            'number'=>trans('view.'.'number'),
            'textarea'=>trans('view.'.'textarea'),
            'url'=>trans('view.'.'url'),
            'color'=>trans('view.'.'color'),
            'select2users'=>trans('view.'.'select2users'));
    //'file'=>'file','button'=>'button','datetime'=>'datetime','datetime-local'=>'datetime-local','month'=>'month','week'=>'week','time'=>'time','umeditor'=>'编辑器','array'=>'列表（必填属性选项/数据列组）','radio'=>'radio（必填属性选项/数据列组）','hidden'=>'隐藏框','search'=>'搜索框','range'=>'百分比框','price'=>'价格输入框','password'=>'密码输入框','tel'=>'电话号码输入框',
?>
<!-- Frontend Input Field -->
<div class="form-group col-sm-2">
    {!! Form::label('frontend_input', 'Frontend Input:') !!}
    {!! Form::select('frontend_input',$frontend_inputs, (!Request::is('tasktypeEavs/create*')) ? $tasktypeEav->frontend_input : null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Is Required Field -->
<div class="form-group col-sm-2">
    {!! Form::label('is_required', 'Is Required:') !!}
    {!! Form::select('is_required',['1'=>'Yes','2'=>'No'], (!Request::is('tasktypeEavs/create*')) ? $tasktypeEav->is_required : 2, ['class' => 'form-control','required'=>'required']) !!}
</div>

{{--<!-- Is Unique Field -->--}}
{{--<div class="form-group col-sm-2">--}}
    {{--{!! Form::label('is_unique', 'Is Unique:') !!}--}}
    {{--{!! Form::select('is_unique', ['1'=>'Yes','2'=>'No'], (!Request::is('tasktypeEavs/create*')) ? $tasktypeEav->is_unique : 2, ['class' => 'form-control','required'=>'required']) !!}--}}
{{--</div>--}}

<!-- Report Field -->
<div class="form-group col-sm-2">
    {!! Form::label('is_report', 'Report:') !!}
    {!! Form::select('is_report', [0=>'No',1=>'Yes'],  null, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Frontend Size Field -->
<div class="form-group col-sm-2">
    {!! Form::label('frontend_size', 'Frontend Size:') !!}
    {!! Form::select('frontend_size', ['3' => '25%'.trans('view.Width'),'4' => '33%'.trans('view.Width'),'6' => '50%'.trans('view.Width'),'8' => '66%'.trans('view.Width'),'9' => '75%'.trans('view.Width'),'12' => '100%'.trans('view.Width')], 6, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- orderby Field -->
<div class="form-group col-sm-2">
    {!! Form::label('orderby', 'orderby:') !!}
    {!! Form::number('orderby', (!Request::is('tasktypeEavs/create*')) ? $tasktypeEav->orderby : 0, ['class' => 'form-control','required'=>'required']) !!}
</div>

<!-- Option Field -->
<div class="form-group col-sm-12">
    {!! Form::label('option', 'Option:') !!}
    {!! Form::select('option[]',(!Request::is('tasktypeEavs/create*')) ? array_combine(explode('|',$tasktypeEav->option),explode('|',$tasktypeEav->option)) : [], (!Request::is('tasktypeEavs/create*')) ?  explode('|',$tasktypeEav->option) : null, ['class' => 'form-control select2-tags','multiple'=>'multiple']) !!}
</div>
@section('scripts')
    <script type="text/javascript">
        $(".select2-tags").select2({
            tags: true
        });
    </script>
@endsection

<!-- Note Field -->
<div class="form-group col-sm-12">
    {!! Form::label('note', 'Note:') !!}
    {!! Form::textarea('note', (!Request::is('tasktypeEavs/create*')) ? $tasktypeEav->note : null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('tasktypes.edit',$tasktype_id) !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>
