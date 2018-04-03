
{{--<!-- huayan -->--}}
{{--<style>--}}
    {{--#bentitle{--}}
        {{--appearance:none;--}}
        {{---moz-appearance:none;--}}
        {{---webkit-appearance:none;--}}
    {{--}--}}
{{--</style>--}}

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

<!-- Informed Field 
<div class="form-group col-sm-4 widget">
    <h5 class="wlabel"><b>@lang('db.informed')</b></h5>
    <h5 class="wvalue">{!! implode(', ',$task->informedlist) !!}</h5>
</div>-->


<?php //huayan
    $tasktype=\App\Models\Tasktype::find($task->tasktype_id);
?>

{{--找到tasktypes对应的bentity_id集合；循环显示，如下：--}}
@foreach(explode('|',$tasktype->bentity_id) as $bentity)

    <div class="form-group col-sm-12">
        <?php
        //{{-- 通过上面获取到的bentity_id找到对应的bentity--}}
        $ben=(\App\Models\Bentity::find($bentity));
        ?>

        @if(!empty($ben))

            <?php
            //{{--通过当前编辑的task_id，在配置表查找是否有task_id相关数据--}}
            $bensets=(App\Models\BentitSet::where('task_id', $task->id)->get());

            if (!empty($bensets)) {
                $entityArray = [];
                foreach ($bensets as $benset) {
                    if ($benset->bentity->tasktype_id==$ben->tasktypes_id) {
                        $entityArray[$benset->ben_title_id]=$benset->bentity->title;
                    }
                }
            }
            /*为什么这里一定要写才可以，否则就死循环*/
            echo("<h5> $ben->name </h5>");

            ?>

                {!! Form::select('bentitle[]',$entityArray, null, ['class' => 'form-control select2-ajax-bentitle '.$ben->tasktypes_id,'id'=>'bentitle']) !!}
        @endif

    </div>
    @endforeach



















<!-- Project Id Field -->
{{--<div class="form-group col-sm-4 widget">--}}
    {{--<h5 class="wlabel"><b>@lang('db.project_id')</b></h5>--}}
    {{--<h5 class="wvalue">{!! $task->project_name !!}</h5>--}}
{{--</div>--}}

{{--<!-- product Id Field -->--}}
{{--<div class="form-group col-sm-4 widget">--}}
    {{--<h5 class="wlabel"><b>@lang('db.product_id')</b></h5>--}}
    {{--<h5 class="wvalue">{!! $task->product_name !!}</h5>--}}
{{--</div>--}}

@include('tasks.eav_show_fields')