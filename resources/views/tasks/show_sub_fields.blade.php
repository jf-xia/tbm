@if($subTask)
<section class="content-header">
    <h1>
        @lang('view.lastTask')
    </h1>
</section>

<div class="box box-primary">
    <div class="box-body">
        <div class="row" style="padding-left: 20px">
<div class="col-md-12">
    <!-- The time line -->
    <ul class="timeline">
        @foreach($subTask as $stask)
        <!-- timeline time label -->
        <li class="time-label">
                  <span class="bg-red">
                    {{ $stask->created_at }}
                  </span>
        </li>
        <!-- /.timeline-label -->
        <!-- timeline item -->
        <li>
            <i class="fa fa-envelope bg-blue"></i>

            <div class="timeline-item">
                @if($stask->id==$task->id)
                    <h2>@lang('view.Current Task')</h2>
                @else
                <span class="time"><i class="fa fa-clock-o"></i>@lang('db.updated_at'): {{ $stask->updated_at }}</span>

                <h3 class="timeline-header">({{ $stask->taskstatus_name }})
                    {{ $stask->tasktype_name }}
                    @lang('view.Task') to <a target="_blank" href="{{ route('index.user',$stask->user->id) }}">
                        {{ $stask->user->name }}</a>
                    [{{ $stask->title }}]
                </h3>

                <div class="timeline-body">
                    <?php $stask=$stask; ?>
                    @include('tasks.eav_show_fields')
                    <div class="clearfix"></div>
                </div>
                @if($stask->end_at) <span class="time"><i class="fa fa-clock-o"></i>@lang('db.end_at'): {{ $stask->end_at }}</span> @endif
                <div class="timeline-footer">
                    @if($stask->informed) <a class="btn btn-primary btn-xs" >@lang('db.informed'):{{ implode(', ',$stask->informedlist) }}</a> @endif
                    @if($stask->assigned_to) <a class="btn btn-dropbox btn-xs" >@lang('db.assigned_to'):{{ $stask->assigned->name }}</a> @endif
                    @if($stask->hours) <a class="btn btn-danger btn-xs" >@lang('db.hours'):{{ $stask->hours }}</a> @endif
                    @if($stask->price) <a class="btn btn-default btn-xs" >@lang('db.price'):{{ $stask->price }}</a> @endif
                    <span class="btn btn-pinterest btn-xs" >@lang('db.project_id'):{!! $stask->project_name !!}</span>
                    <span class="btn btn-warning btn-xs" >@lang('db.product_id'):{!! $stask->product_name !!}</span>
                </div>
                @endif
            </div>
        </li>
        <!-- END timeline item -->
            @foreach($groupComments->where('task_id','=',$stask->id)->where('grade','<>',0) as $comm)
            <!-- timeline item -->
            <li>
                <i class="fa fa-comments bg-yellow"></i>

                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock-o"></i>{{ $comm->updated_at }}</span>

                    <h3 class="timeline-header"><a target="_blank" href="{{ route('index.user',$comm->user->id) }}">{{ $comm->user->name }}</a> @lang('view.commented on') {{ $stask->user->name }}'s @lang('view.Task')</h3>

                    <div class="timeline-body">{{ $comm->comment }}</div>
                </div>
            </li>
            <!-- END timeline item -->
            @endforeach
        @endforeach
        <li>
            <i class="fa fa-clock-o bg-gray"></i>
        </li>
    </ul>
</div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

@endif

