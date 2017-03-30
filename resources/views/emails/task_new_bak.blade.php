<!doctype html>
<head>
    <meta charset="UTF-8" />
    <style type="text/css">
        .box.box-primary {
            border-top-color: #3c8dbc;
        }
        .box {
            position: relative;
            border-radius: 3px;
            background: #ffffff;
            border-top: 3px solid #d2d6de;
            margin-bottom: 20px;
            width: 100%;
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
        }
        .widget {
            width: 48%;
            background-color: whitesmoke;
            border-right: 14px solid #FFF;
            border-bottom: 2px solid #FFF;
            border-top: 2px solid #FFF;
            float: left;
        }
        .widget .elabel{
            white-space: nowrap;
        }
        .widget .wlabel{
            float: left;
            width: 90px;
            overflow: hidden;
            clear: left;
            text-align: right;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .widget .wlabel:hover{
            overflow: inherit;
            white-space: normal;
        }
        .widget .wvalue{
            margin-left: 100px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .widget .wvalue:hover{
            overflow: inherit;
            white-space: normal;
        }
        .clearfix {
            clear: both;
        }
        .timeline {
            position: relative;
            margin: 0 0 30px 0;
            padding: 0;
            list-style: none;
        }
        .timeline:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 4px;
            background: #ddd;
            left: 31px;
            margin: 0;
            border-radius: 2px;
        }
        .timeline>li {
            position: relative;
            margin-right: 10px;
            margin-bottom: 15px;
        }
        .timeline>.time-label>span {
            font-weight: 600;
            padding: 5px;
            display: inline-block;
            background-color: #fff;
            border-radius: 4px;
        }
        .timeline>li>.timeline-item {
            -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            box-shadow: 0 1px 1px rgba(0,0,0,0.1);
            border-radius: 3px;
            margin-top: 0;
            background: #fff;
            color: #444;
            margin-left: 60px;
            margin-right: 15px;
            padding: 0;
            position: relative;
        }
        .timeline>li>.fa, .timeline>li>.glyphicon, .timeline>li>.ion {
            width: 30px;
            height: 30px;
            font-size: 15px;
            line-height: 30px;
            position: absolute;
            color: #666;
            background: #d2d6de;
            border-radius: 50%;
            text-align: center;
            left: 18px;
            top: 0;
        }
        .timeline>li>.timeline-item>.time {
            color: #999;
            float: right;
            padding: 10px;
            font-size: 12px;
        }
        .timeline>li>.timeline-item>.timeline-header {
            margin: 0;
            color: #555;
            border-bottom: 1px solid #f4f4f4;
            padding: 10px;
            font-size: 16px;
            line-height: 1.1;
        }
        .timeline>li>.timeline-item>.timeline-body, .timeline>li>.timeline-item>.timeline-footer {
            padding: 10px;
        }
        .bg-red, .callout.callout-danger, .alert-danger, .alert-error, .label-danger, .modal-danger .modal-body {
            background-color: #dd4b39 !important;
        }
        .bg-blue {
            background-color: #0073b7 !important;
        }

    </style>
</head>
<body>


<section class="content-header">
    <h3>
        Hi {{ implode(', ',$task->informedlist) }}:<br /><br />
        {{ $task->user->name }} {{ $task->taskstatus->name }} {{ $task->tasktype->name }} @lang('view.Task') [{{ $task->title }}]
        <small><i><a href="{{ url('') }}"  style="color: #c4e3f3" >@lang('view.THIS IS AN AUTOMATIC EMAIL, PLEASE DO NOT REPLY TO THIS MESSAGE.')</a> </i></small>
        <br /><br />
        {{--@if($task->assigned_to) @lang('db.assigned_to'):{{ $task->assigned->name }}; @endif--}}
        @if($task->end_at) @lang('db.end_at'): {{ date('Y-m-d',strtotime($task->end_at)) }}; @endif
        @if($task->hours) @lang('db.hours'):{{ $task->hours }}; @endif
        @if($task->price) @lang('db.price'):{{ $task->price }}; @endif
        @lang('db.project_id'):{!! $task->project_name !!};
        @lang('db.product_id'):{!! $task->product_name !!};
    </h3>
</section>
<div class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="row" style="padding-left: 20px">
                <?php
                $atts=$atts->taskTypeEav($task->tasktype_id);
                $eavValue=$eavValue->eavValue($task->id);
                ?>
                @if($atts)
                    @foreach($atts as $attribute)
                        <div class="form-group col-sm-{{ $attribute->frontend_size }} widget">
                        <h5 class="wlabel"><b><label for="{{ $attribute->code }}">{{ $attribute->frontend_label }}</label></b></h5>
                        <?php
                        $type=$attribute->frontend_input;
                        $select=explode('2',$type);
                        ?>
                        @if(count($select)>1)
                            <h5 class="wvalue">{!! isset($eavValue[$attribute->id])&&$eavValue[$attribute->id]>0 ? \App\User::find($eavValue[$attribute->id],['name'])->name : null !!}</h5>
                        @else
                            <h5 class="wvalue">{{ isset($eavValue[$attribute->id]) ? $eavValue[$attribute->id] : null }}</h5>
                        @endif
                    </div>
                    @endforeach
                @endif

                        <!-- Content Field -->
                <div class="form-group col-sm-12 widget">
                    <h5 class="wlabel"><b>@lang('db.content')</b></h5>
                    <h5 class="wvalue">{!! $task->content !!}</h5>
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
                            <li class="time-label">
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

                                    <h3 class="timeline-header">({{ $task->taskstatus->name }})
                                        {{ $task->tasktype->name }}
                                        @lang('view.Task') to <a href="{{ route('index.user',$task->user->id) }}">
                                            {{ $task->user->name }}</a>
                                        [{{ $task->title }}]
                                    </h3>

                                    <div class="timeline-body">
                                        @include('tasks.eav_show_fields')
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