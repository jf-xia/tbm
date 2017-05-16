<!doctype html>
<head>
    <meta charset="UTF-8">
</head>
<body>


<section class="content-header">
    <h3>
        Hi {{ implode(', ',$task->informedlist) }}:<br><br>
        {{ $task->user->name }} {{ $task->taskstatus_name }} {{ $task->tasktype_name }} @lang('view.Task') [{{ $task->title }}]<br>
        <small><i><a href="{{ url('') }}" style="color: #c4e3f3">@lang('view.THIS IS AN AUTOMATIC EMAIL, PLEASE DO NOT REPLY TO THIS MESSAGE.')</a> </i></small>
        <br><br>
        {{--@if($task->assigned_to) @lang('db.assigned_to'):{{ $task->assigned->name }}; @endif--}}
        @if($task->end_at) @lang('db.end_at'): {{ date('Y-m-d',strtotime($task->end_at)) }}; @endif
        @if($task->hours) @lang('db.hours'):{{ $task->hours }}; @endif
        @if($task->price) @lang('db.price'):{{ $task->price }}; @endif
        <br >@lang('db.product_id'):{!! $task->product_name !!}
		<br >@lang('db.project_id'):{!! $task->project_name !!}
    </h3>
</section>
<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                <?php
                $atts1=$atts->taskTypeEav($task->tasktype_id);
                $eavValue1=$eavValue->eavValue($task->id);
                ?>
                @if($atts1)
                    @foreach($atts1 as $attribute)
                        <div class="form-group col-sm-{{ $attribute->frontend_size }} widget">
                            <b><label for="{{ $attribute->code }}">{{ $attribute->frontend_label }}:</label></b>
                            <?php
                            $type=$attribute->frontend_input;
                            $select=explode('2',$type);
                            ?>
                            @if(count($select)>1)
                                {!! isset($eavValue1[$attribute->id])&&$eavValue1[$attribute->id]>0 ? \App\User::find($eavValue1[$attribute->id],['name'])->name : null !!}
                            @else
                                {{ isset($eavValue1[$attribute->id]) ? $eavValue1[$attribute->id] : null }}
                            @endif
                            <br>
                        </div>
                        @endforeach
                        @endif

                                <!-- Content Field -->
                        <div class="form-group col-sm-12 widget">
                            <b>@lang('db.content'):</b>
                            {!! $task->content !!}<br>
                        </div>
                        <div class="clearfix"></div>
            </div>
        </div>
    </div>@if($subTask)
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
                            @foreach($subTask as $task)
                                    <!-- timeline time label -->
                            <li class="time-label"  style="border: 1px solid #aaa;">
                  <span class="bg-red">
                    {{ $task->created_at }}
                  </span>
                            </li>
                            <!-- /.timeline-label -->
                            <!-- timeline item -->
                            <li>
                                <i class="fa fa-envelope bg-blue"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i>@lang('db.updated_at'): {{ $task->updated_at }}</span>

                                    <h3 class="timeline-header">({{ $task->taskstatus_name }})
                                        {{ $task->tasktype_name }}
                                        @lang('view.Task') to <a href="{{ route('index.user',$task->user->id) }}">
                                            {{ $task->user->name }}</a>
                                        [{{ $task->title }}]
                                    </h3>

                                    <div class="timeline-body">

                                        <?php
                                        $atts2=$atts->taskTypeEav($task->tasktype_id);
                                        $eavValue2=$eavValue->eavValue($task->id);
                                        ?>
                                        @if($atts2)
                                            @foreach($atts2 as $attribute)
                                                <div class="form-group col-sm-{{ $attribute->frontend_size }} widget">
                                                    <b><label for="{{ $attribute->code }}">{{ $attribute->frontend_label }}:</label></b>
                                                    <?php
                                                    $type=$attribute->frontend_input;
                                                    $select=explode('2',$type);
                                                    ?>
                                                    @if(count($select)>1)
                                                        {!! isset($eavValue2[$attribute->id])&&$eavValue2[$attribute->id]>0 ? \App\User::find($eavValue2[$attribute->id],['name'])->name : null !!}
                                                    @else
                                                        {{ isset($eavValue2[$attribute->id]) ? $eavValue2[$attribute->id] : null }}
                                                    @endif
                                                </div>
                                                @endforeach
                                                @endif

                                                        <!-- Content Field -->
                                                <div class="form-group col-sm-12 widget">
                                                    <b>@lang('db.content'):</b>
                                                    {!! $task->content !!}
                                                </div>

                                                <div class="clearfix"></div>
                                    </div>
                                    @if($task->end_at) <span class="time"><i class="fa fa-clock-o"></i>@lang('db.end_at'): {{ $task->end_at }}</span> @endif
                                    <div class="timeline-footer">
                                        @if($task->informed) <a class="btn btn-primary btn-xs" >@lang('db.informed'):{{ implode(', ',$task->informedlist) }}</a> @endif
                                        @if($task->assigned_to) <a class="btn btn-dropbox btn-xs" >@lang('db.assigned_to'):{{ $task->assigned->name }}</a> @endif
                                        @if($task->hours) <a class="btn btn-danger btn-xs" >@lang('db.hours'):{{ $task->hours }}</a> @endif
                                        @if($task->price) <a class="btn btn-default btn-xs" >@lang('db.price'):{{ $task->price }}</a> @endif
                                        <span class="btn btn-pinterest btn-xs" >@lang('db.project_id'):{!! $task->project_name !!}</span>
                                        <span class="btn btn-warning btn-xs" >@lang('db.product_id'):{!! $task->product_name !!}</span>
                                    </div>
                                </div>
                            </li>
                            <!-- END timeline item -->
                            @foreach($groupComments->where('task_id','=',$task->id)->where('grade','<>',0) as $comm)
                                    <!-- timeline item -->
                            <li>
                                <i class="fa fa-comments bg-yellow"></i>

                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i>{{ $comm->updated_at }}</span>

                                    <h3 class="timeline-header"><a href="{{ route('index.user',$task->user->id) }}">{{ $comm->user->name }}</a> @lang('view.commented on') {{ $task->user->name }}'s @lang('view.Task')</h3>

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
</div>



</body>
</html>