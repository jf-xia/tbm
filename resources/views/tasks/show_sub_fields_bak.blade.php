
<div class="timeline-footer">
    <a class="btn btn-primary btn-xs" href="{{ route('tasks.show',$task->id) }}" >@lang('view.Read more')</a>
</div>

@if($subTask)
<section class="content-header">
    <h1>
        @lang('view.lastTask')@lang('view.show')
    </h1>
</section>
@foreach($subTask as $sTask)
<div class="box box-primary">
    <div class="box-body">
        <div class="row" style="padding-left: 20px">
            <!-- Title Field -->
            <div class="form-group col-sm-6 widget">
                <h5 class="wlabel"><b>{!! Form::label('title', 'Title:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->title !!}</h5>
            </div>

            <!-- User Id Field -->
            <div class="form-group col-sm-2 widget">
                <h5 class="wlabel"><b>{!! Form::label('user_id', 'User Id:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->user->name !!}</h5>
            </div>

            <!-- Taskstatus Id Field -->
            <div class="form-group col-sm-2 widget">
                <h5 class="wlabel"><b>{!! Form::label('taskstatus_id', 'Taskstatus Id:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->taskstatus_name !!}</h5>
            </div>

            <!-- Hours Field -->
            <div class="form-group col-sm-2 widget">
                <h5 class="wlabel"><b>{!! Form::label('hours', 'Hours:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->hours !!}</h5>
            </div>

            <!-- Tasktype Id Field -->
            <div class="form-group col-sm-3 widget">
                <h5 class="wlabel"><b>{!! Form::label('tasktype_id', 'Tasktype Id:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->tasktype_name !!}</h5>
            </div>

            <!-- Created At Field -->
            <div class="form-group col-sm-3 widget">
                <h5 class="wlabel"><b>{!! Form::label('created_at', 'Created At:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->created_at !!}</h5>
            </div>

            <!-- Updated At Field -->
            <div class="form-group col-sm-3 widget">
                <h5 class="wlabel"><b>{!! Form::label('updated_at', 'Updated At:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->updated_at !!}</h5>
            </div>

            <!-- End At Field -->
            <div class="form-group col-sm-3 widget">
                <h5 class="wlabel"><b>{!! Form::label('end_at', 'End At:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->end_at !!}</h5>
            </div>

            <!-- Informed Field -->
            <div class="form-group col-sm-6 widget">
                <h5 class="wlabel"><b>{!! Form::label('informed', 'Informed:') !!}</b></h5>
                <h5 class="wvalue">{!! implode(', ',$sTask->informedlist) !!}</h5>
            </div>

            <!-- Project Id Field -->
            <div class="form-group col-sm-6 widget">
                <h5 class="wlabel"><b>{!! Form::label('project_id', 'Project Id:') !!}</b></h5>
                <h5 class="wvalue">{!! $sTask->project_name !!}</h5>
            </div>

            @foreach($atts as $attribute)
                <div class="form-group col-sm-{{ $attribute->frontend_size }} widget">
                    <h5 class="wlabel"><b><label for="{{ $attribute->code }}">{{ $attribute->frontend_label }}</label></b></h5>
                    <?php
                    $type=$attribute->frontend_input;
                    $select=explode('2',$type);
                    ?>
                    @if(count($select)>1)
                        <h5 class="wvalue">{!! isset($eavValue[$attribute->id]) ? \App\User::find($eavValue[$attribute->id],['name'])->name : null !!}</h5>
                    @else
                        <h5 class="wvalue">{{ isset($eavValue[$attribute->id]) ? $eavValue[$attribute->id] : null }}</h5>
                    @endif
                </div>
            @endforeach

                <!-- Content Field -->
                <div class="form-group col-sm-12 widget">
                    <h5 class="wlabel"><b>{!! Form::label('content', 'Content:') !!}</b></h5>
                    <h5 class="wvalue">{!! $sTask->content !!}</h5>
                </div>
        </div>
    </div>
</div>
@endforeach
@endif