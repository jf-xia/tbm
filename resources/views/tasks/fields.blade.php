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

@if($task->tasktype->bentity_id)
    @foreach(explode('|',$task->tasktype->bentity_id) as $bentity)
        <div class="form-group col-sm-12">
            <?php $ben=(\App\Models\Bentity::find($bentity)); ?>
            @if(!empty($ben))
                    <?php //dd('dd'); ?>
            <?php
                $bensets=(App\Models\BentitSet::where('task_id', $task->id)->get());
                if (!empty($bensets)) {
                    $entityArray = [];
                    foreach ($bensets as $benset) {
                        if ($benset->bentity->tasktype_id==$ben->tasktypes_id) {
                            $entityArray[$benset->ben_title_id]=$benset->bentity->title;
                        }
                    }
                }
                echo("<label> $ben->name </label>");
            ?>
               {!! Form::select('bentitle[]',$entityArray, null, ['class' => 'form-control select2-ajax-bentitle'.$ben->tasktypes_id,]) !!}
            @endif
        </div>
    @endforeach
@endif

@include('tasks.eav_fields')

<?php $informedlist=($task->informedlist);?>
<div class="form-group col-sm-12">
    {!! Form::label('informed', 'informed:') !!}
    {!! Form::select('informed[]',$informedlist, $task->informed, ['class' => 'form-control select2-ajax-users','multiple'=>'multiple']) !!}
</div>

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
        @foreach(explode('|',$task->tasktype->bentity_id) as $bentity)
            <?php  $bentask_type=(\App\Models\Bentity::find($bentity)) ?>
            @if(!empty($bentask_type))
                select2(".select2-ajax-bentitle{!! $bentask_type->tasktypes_id !!}","/tasks/benajaxlist?bentask_type={!! $bentask_type->tasktypes_id !!}");
        @endif
        @endforeach
    </script>
@endsection