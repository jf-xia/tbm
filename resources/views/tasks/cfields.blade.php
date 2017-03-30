{!! Form::hidden('tasktype_id', $tasktype_id, ['class' => 'form-control']) !!}

<!-- Title Field -->
<div class="form-group col-sm-6">
    {!! Form::label('title', 'Title:') !!}
    {!! Form::text('title', null, ['class' => 'form-control','required']) !!}
</div>

<!-- Taskstatus Field -->
<div class="form-group col-sm-2">
    {!! Form::label('taskstatus_id', 'Taskstatus:') !!}
    {!! Form::select('taskstatus_id',$selectTaskstatus ,null, ['class' => 'form-control','required']) !!}
</div>

<!-- End At Field -->
<div class="form-group col-sm-2">
    {!! Form::label('end_at', 'End At:') !!}
    {!! Form::text('end_at',date('Y-m-d H:i:s'), ['class' => 'form-control','required','data-inputmask'=>"'alias': 'yyyy-mm-dd hh:mm:ss'"]) !!}
    {{--{!! Form::date('end_at',null, ['class' => 'form-control','required'=>'required']) !!}--}}
</div>

<!-- Hours Field -->
<div class="form-group col-sm-2">
    {!! Form::label('hours', 'Hours:') !!}
    {!! Form::text('hours', 0.5, ['class' => 'form-control','required','data-inputmask'=>'"mask": "9.9"']) !!}
    {{--{!! Form::number('hours', 1, ['class' => 'form-control','required'=>'required','min'=>'1','max'=>'10']) !!}--}}
</div>

{{--<div class="form-group col-sm-12"><button onclick="javascript:$('.optionally').each(function(){ $(this).show(); });$(this).hide();" type="button" class="btn btn-default btn-block" > @lang('view.Display optionally form') <span class="caret"></span></button></div>--}}

@if($tasktype->project_required)
<div class="form-group col-sm-12">
    {!! Form::label('project_id', 'project_id:') !!}
    {!! Form::select('project_id',[], null, ['class' => 'form-control select2-ajax-projects','required']) !!}
</div>
@endif

@if($tasktype->product_required)
<div class="form-group col-sm-12">
    {!! Form::label('product_id', 'product_id:') !!}
    {!! Form::select('product_id',[], null, ['class' => 'form-control select2-ajax-products','required']) !!}
</div>
@endif

<div class="form-group col-sm-12">
    {!! Form::label('informed', 'informed:') !!}
    {!! Form::select('informed[]',[], null, ['class' => 'form-control select2-ajax-users','multiple'=>'multiple']) !!}
</div>
@section('scripts')
    <script type="text/javascript">
        select2(".select2-ajax-users","/tasks/usersajaxlist");
        select2(".select2-ajax-projects","/tasks/projectsajaxlist");
        select2(".select2-ajax-products","/tasks/productajax");

        //$('.optionally').each(function(){ $(this).hide();});
    </script>
@endsection

@foreach($atts as $attribute)
    <div class="form-group col-sm-{{ $attribute->frontend_size }}">
        <label for="{{ $attribute->code }}">{{ $attribute->frontend_label }}</label>
    <?php
        $type=$attribute->frontend_input;
        $select=explode('2',$type); $htmlClass=['class' => 'form-control'];
        if ($attribute->is_required==1) {
            $htmlClass['required']='required';
        }
        $option=explode('|',$attribute->option);
    ?>
    @if($type=='select')
        {!! Form::select('attribute['.$attribute->id.']',array_combine($option,$option), null, $htmlClass) !!}
    @elseif($select[0]=='select')
        <?php $htmlClass['class']=$htmlClass['class'].' select2-ajax-'.$select[1]; ?>
        {!! Form::select('attribute['.$attribute->id.']', [], null, $htmlClass) !!}
        @section('scripts')
            <script type="text/javascript">
                select2(".select2-ajax-{{ $select[1] }}", "/tasks/{{ $select[1] }}ajaxlist");
            </script>
        @endsection
    @else
        {!! Form::$type('attribute['.$attribute->id.']', null, $htmlClass) !!}
    @endif
    </div>
@endforeach

<div class="form-group col-sm-12" >
    {!! Form::label('content', 'Content:') !!}
    <textarea id="content" name="content"></textarea>
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