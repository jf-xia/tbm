@extends('layouts.app')

@section('css')
    <!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="{{ URL::asset('vendor/fullcalendar/fullcalendar.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/fullcalendar/fullcalendar.print.css') }}" media="print">
@endsection



@section('content')
<section class="content-header">
    <h1>@lang('view.Calendar')
        <input id="user_id" type="hidden" value="{{ \Auth::id() }}">
        @if(count($myTeams)>1)
        <div class="form-group col-sm-2">
            {!! Form::select('taskstatus_select',array_flip($myTeams),\Auth::id(),
                ['class' => 'form-control','onchange'=>"optionUpdate(this)"]) !!}
        </div>
        @endif
    </h1>
</section>

<section class="content">

    <div class="row">
        {{--<div id='loading'>loading...</div>--}}
        <!-- /.col -->
        <div class="col-md-12">
        </div>
        <!-- /.col -->

        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3" id="droppable">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">@lang('view.Create Event')</h3>
                </div>
                <div class="box-body">
                    <!-- /btn-group -->
                    <div class="form-group col-sm-12">
                        <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                            {!! Form::select('tasktype',$tasktype,null, ['class' => 'form-control','id'=>'tasktype']) !!}
                            <textarea id="new-event" rows="3" class="form-control" placeholder="@lang('view.Event Title placeholder')" ></textarea>
                            <button id="add-new-event" type="button" class="btn btn-default">@lang('view.Add')</button>
                        </div>
                    </div>
                    <!-- /input-group -->
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">@lang('view.Draggable Events')</h4>
                    <br /><i>@lang('view.Events are Uncertain')</i>
                </div>
                <div class="box-body">
                    <!-- the events -->
                    <div id="external-events">
                        @foreach($tasks as $task)
                            <div class="external-event" style="background-color:{{ $task->color }};color:#fff"
                                 tasktype="{{ $task->tasktype_id }}" tid="{{ $task->id }}" id="task{{ $task->id }}"
                                onclick="$(this).children('.event-list').toggle()">
                                <span class="event-list" style="display: none">
                                    <a target="_blank" class="glyphicon glyphicon-eye-open" title="@lang('view.show')" href="{{ route('tasks.show',$task->id) }}"> </a>
                                    <a target="_blank" class="glyphicon glyphicon-edit" title="@lang('view.Edit')" href="{{ route('tasks.edit',$task->id) }}"> </a>
                                    <a class="glyphicon glyphicon-trash" title="@lang('view.Delete')" href="javascript:deleteAction({{ $task->id }})"> </a>
                                </span>
                                {{ $task->title }}
                            </div>
                        @endforeach
                        <div class="checkbox">
                            <label for="delete-remove">
                                <input type="checkbox" id="delete-remove" checked >
                                @lang('view.Delete as move')
                            </label>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
        </div>


    </div>
</section>
@endsection

@section('scripts')
<!-- fullCalendar 2.2.5 -->
<script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendor/fullcalendar/fullcalendar.min.js') }}"></script>
<script src='{{ URL::asset('vendor/fullcalendar/locale/zh-cn.js') }}'></script>
<!-- Page specific script -->

<script>

//    $('.external-event').mouseover(function(e) {
//        $(this).children('.event-list').show();
//    });

    function optionUpdate(elm){
        $('#user_id').val($(elm).children('option:selected').val());
        $("#calendar").fullCalendar("refetchEvents");
        if ($('#user_id').val() == {{ \Auth::id() }}){
            $('#calendar').fullCalendar('option', {editable: true, droppable: true});
            $('#droppable').show();
        } else {
            $('#calendar').fullCalendar('option', {editable: false, droppable: false});
            $('#droppable').hide();
        }
    }

    /* initialize the external events */
    function ini_events(ele) {
        ele.each(function () {

            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()),
                tasktype: $.trim($(this).attr('tasktype',$('#tasktype').val()))
            };

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);

            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 1070,
                revert: true, // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });

        });
    }

    ini_events($('#external-events div.external-event'));

    $("#add-new-event").click(function (e) {
        e.preventDefault();
        //Get value and make sure it is not null
        var val = $("#new-event").val();
        if (val.length < 2) {
            return;
        }

//WHEN '*' THEN '#00c0ef' WHEN '!' THEN '#dd4b39' WHEN '^' THEN '#00a65a' WHEN '~' THEN '#3c8dbc'
        var currColor = "#666";
        switch(val.substring(0,1)) {
            case '*':currColor = '#00c0ef';break;
            case '!':currColor = '#dd4b39';break;
            case '^':currColor = '#00a65a';break;
            case '~':currColor = '#3c8dbc';break;
        }

        var event = {title:val, tasktype: $('#tasktype').val(),"backgroundColor": currColor, "borderColor": currColor, "color": "#fff"};

        $.ajax({
            url: '{{ route('tasks.createajax') }}', type: 'GET',
            data: {
                title:event.title, tasktype_id: event.tasktype,
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(doc) {
                //Create events
                event.id = doc;
                createEvent(event);
            }
        });
    });

    function createEvent(event){
        var eventHtml = $("<div />");
        var tooltip = '<span class="event-list" style="display:none" >'
                +'<a target="_blank" class="glyphicon glyphicon-eye-open" title="@lang('view.show')" href="{{ url('') }}/tasks/' + event.id + '"> </a> '
                +'<a target="_blank" class="glyphicon glyphicon-edit" title="@lang('view.Edit')" href="{{ url('') }}/tasks/' + event.id + '/edit"> </a> '
                +'<a class="glyphicon glyphicon-trash" title="@lang('view.Delete')" href="javascript:deleteAction(' + event.id + ')"> </a> '
                +'</span>';
        eventHtml.css({"background-color": event.backgroundColor, "border-color": event.borderColor, "color": "#fff"}).addClass("external-event");
        eventHtml.html(tooltip + event.title);
        eventHtml.attr('tid',event.id);
        eventHtml.attr('tasktype',event.tasktype);
        eventHtml.attr('onclick',"$(this).children('.event-list').toggle()");
        $('#external-events').prepend(eventHtml);

        $("#new-event").val("");
        ini_events(eventHtml);
//        return eventHtml;
    }

    function getTask(start,end,callback){
        $.ajax({
            url: '{{ route('tasks.listajax') }}',
            dataType: 'json',
            data: {
                // our hypothetical feed requires UNIX timestamps
                start: start.unix(),
                end: end.unix(),
                user_id: $('#user_id').val(),
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(doc) {
                var events = [];
                $(doc).each(function() {
                    var borderColor = 'black';
                    if ($(this).attr('taskstatus')==5){
                        var borderColor = '#fff';
                    }
                    events.push({
                        id: $(this).attr('id'),
                        title: $(this).attr('title'),
                        start: $(this).attr('startat'), // will be parsed
                        end: $(this).attr('endat'),
                        taskstatus: $(this).attr('taskstatus'),
                        tasktype: $(this).attr('tasktype_id'),
                        hours: $(this).attr('hours'),
                        price: $(this).attr('price'),
//                                url: '/tasks/'+$(this).attr('id'),
                        backgroundColor: $(this).attr('color'),
                        allDay: $(this).attr('allday'),
                        borderColor: borderColor
                    });
                });
                callback(events);
            }
        });
    }

    function updateTask(event){
        var id = event.id, end_at = event.start,
                hours = event.hours; //(Number(moment(event.end).diff(start)/3600000)).toFixed(1);
//        console.log('eventDrop', id,start,hour);
        $.ajax({
            url: '{{ route('tasks.updateajax') }}',
            type: 'GET',
            data: {
                id:id,
                end_at: end_at.format('YYYY-MM-DD HH:mm:ss'),
                hours: hours,
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(doc) {
//                $('#calendar').fullCalendar('updateEvent', event);
                $('#calendar').fullCalendar('renderEvent', event, true);
            }
        });
    }

//    function createTask(event){}
    function shareTask(event_id,share){
        var event = $("#calendar").fullCalendar('clientEvents', event_id)[0];
        event.price = share;
        $.ajax({
            url: '{{ route('tasks.updateajax') }}',
            type: 'GET',
            data: {
                id:event_id,
                price: event.price,
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(doc) {
                $('#calendar').fullCalendar('updateEvent', event);
            }
        });
    }

    function statusTask(event_id,taskstatus){
        var event = $("#calendar").fullCalendar('clientEvents', event_id)[0];
        event.taskstatus = taskstatus;
        event.borderColor = 'black';
        if (taskstatus==5){
            event.borderColor = '#fff';
        }
        $.ajax({
            url: '{{ route('tasks.updateajax') }}',
            type: 'GET',
            data: {
                id:event_id,
                taskstatus_id: taskstatus,
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(doc) {
                $('#calendar').fullCalendar('updateEvent', event);
            }
        });
    }

    /* delete event */
    function deleteTask(event_id){
        if ($('#delete-remove').is(':checked')){
            var event = $("#calendar").fullCalendar('clientEvents', event_id)[0];
            $.ajax({
                url: '{{ route('tasks.updateajax') }}',
                type: 'GET',
                data: {
                    id:event_id,
                    hours: 0,
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                success: function(doc) {
                    createEvent(event);
                    $('#calendar').fullCalendar('removeEvents',event_id);
                }
            });
        } else  {
            var url = "{{ url('') }}/tasks/delete/" + event_id;
            $.ajax({url:url,async:false});
            $('#calendar').fullCalendar('removeEvents',event_id);
        }
    }

    function deleteAction(event_id){
        var url = "{{ url('') }}/tasks/delete/" + event_id;
        $.ajax({url:url,async:false});
        $('#task'+event_id).remove();
    }

    /* clone event */
    function cloneTask(event_id){
        var event = $("#calendar").fullCalendar('clientEvents', event_id)[0];
//        console.log(event);
        $.ajax({
            url: '{{ route('tasks.createajax') }}', type: 'GET',
            data: {
                title:event.title, end_at: event.start.format('YYYY-MM-DD HH:mm:ss'), hours: event.hours,  tasktype_id: event.tasktype,
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(errorThrown);
            },
            success: function(doc) {
                event.id = doc;
                //todo change refetchEvents to refetchEvent for better efficiency
//                $("#calendar").fullCalendar("addEvent",event);
//                $('#calendar').fullCalendar('renderEvent', event, true);
                $("#calendar").fullCalendar("refetchEvents");
            }
        });
//        $('#calendar').fullCalendar('renderEvent',event);
    }


    $(function () {

        /* initialize the calendar */
        var date = new Date();
        var d = date.getDate(), m = date.getMonth(), y = date.getFullYear();
        $('#calendar').fullCalendar({
            timeFormat: 'H(:mm)', minTime: "06:00:00", maxTime: "24:00:00",
            height: 935,
            header: {left: 'prev,next today', center: 'title', right: 'month,agendaWeek,agendaDay,listWeek'}, //,listMonth  timelineDay
            defaultView: 'agendaWeek',
            navLinks: true, weekNumbers: true, eventLimit: true,
//            displayEventTime: false,
//            scrollTime: '00:00',
//            businessHours: true,
            events: function(start, end, timezone, callback) {
                getTask(start,end,callback);
//                cache: true
            },
            eventMouseover: function(calEvent, jsEvent, view){
                if(calEvent.taskstatus!==5){
                    var OK_NOT = '<a class="glyphicon glyphicon-ok-circle" id="taskstatus' + calEvent.id + '" title="@lang('view.Done')" href="javascript:statusTask(' + calEvent.id + ',5)"> </a> ';
                } else {
                    var OK_NOT = '<a class="glyphicon glyphicon-ban-circle" id="taskstatus' + calEvent.id + '"  title="@lang('view.Stop')" href="javascript:statusTask(' + calEvent.id + ',4)"> </a> ';
                }
                if(calEvent.price==0){
                    var Share_NOT = '<a id="sharetask' + calEvent.id + '"  class="glyphicon glyphicon-heart-empty title="@lang('view.Share')" href="javascript:shareTask(' + calEvent.id + ',1)"> </a> ';
                } else {
                    var Share_NOT = '<a id="sharetask' + calEvent.id + '"  class="glyphicon glyphicon-heart" title="@lang('view.Share')" href="javascript:shareTask(' + calEvent.id + ',0)"> </a> ';
                }
                var tooltip = '<span class="event-tooltip" >'
                        +'<a target="_blank" class="glyphicon glyphicon-eye-open" title="@lang('view.show')" href="{{ url('') }}/tasks/' + calEvent.id + '"> </a> '
                        +'<a target="_blank" class="glyphicon glyphicon-edit" title="@lang('view.Edit')" href="{{ url('') }}/tasks/' + calEvent.id + '/edit"> </a> '
                        +'<a class="glyphicon glyphicon-copy" title="@lang('view.Clone')" href="javascript:cloneTask(' + calEvent.id + ')"> </a> '
                        +'<a class="glyphicon glyphicon-trash" title="@lang('view.Delete')" href="javascript:deleteTask(' + calEvent.id + ')"> </a> '
                        + OK_NOT + Share_NOT +'</span>';
                $(this).find('.fc-title').prepend(tooltip);
            },
            eventMouseout: function(calEvent, jsEvent) {$('.event-tooltip').remove();},
            eventResize: function(event) {
                event.hours = (Number(moment(event.end).diff(event.start)/3600000)).toFixed(1);
                updateTask(event);
            },
            eventDrop: function(event) { updateTask(event)},
            editable: true,
            droppable: true,
            drop: function (date) { // this function is called when something is dropped   date, allDay
                var originalEventObject = $(this).data('eventObject');
                var copiedEventObject = $.extend({}, originalEventObject);
                copiedEventObject.id = $(this).attr('tid');
                copiedEventObject.tasktype = $(this).attr('tasktype');
                copiedEventObject.hours = 2;
                copiedEventObject.start = date;
//                copiedEventObject.end = date.add(copiedEventObject.hours,'h');//
//                copiedEventObject.allDay = allDay;
                copiedEventObject.backgroundColor = $(this).css("background-color");
                copiedEventObject.borderColor = 'black';//$(this).css("border-color");
                updateTask(copiedEventObject);

                $(this).remove();
//                console.log('drop', date.add(1,'h').format(),copiedEventObject );
            }
        });
    });

    //            eventClick: function(event) {
    //                // opens events in a popup window
    ////                window.open(event.url);
    //                return false;
    //            },
    //            loading: function(bool) {
    //                $('#loading').toggle(bool);
    //            },
    {{--eventReceive: function(event) { // called when a proper external event is dropped--}}
    {{--var title = event.title, start = event.start.format('YYYY-MM-DD HH:mm:ss'),--}}
    {{--hour = (Number(moment(event.end).diff(start)/3600000)).toFixed(1);--}}
    {{--console.log('eventReceive', title,start,hour);--}}
    {{--$.ajax({--}}
    {{--url: '{{ route('tasks.createajax') }}', type: 'GET',--}}
    {{--data: { title:title, end_at: start, hours: hour,--}}
    {{--},--}}
    {{--error: function(XMLHttpRequest, textStatus, errorThrown) {--}}
    {{--alert(errorThrown);--}}
    {{--},--}}
    {{--success: function(doc) {--}}
    {{--alert(doc);}--}}
    {{--});--}}
    {{--},--}}

    {{--/* ADDING EVENTS */--}}
    {{--var currColor = "#3c8dbc"; //Red by default--}}
    {{--//Color chooser button--}}
    {{--var colorChooser = $("#color-chooser-btn");--}}
    {{--$("#color-chooser > li > a").click(function (e) {--}}
        {{--e.preventDefault();--}}
        {{--//Save color--}}
        {{--currColor = $(this).css("color");--}}
        {{--//Add color effect to button--}}
        {{--$('#add-new-event').css({"background-color": currColor, "border-color": currColor});--}}
        {{--$('#new-event').val($(this).attr('tag')+$('#new-event').val());--}}
    {{--});--}}
{{--WHEN '*' THEN '#00c0ef' WHEN '!' THEN '#dd4b39' WHEN '^' THEN '#00a65a' WHEN '~' THEN '#3c8dbc'--}}
 {{--$("#new-event").val().substring(0, 1)--}}
{{--<!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->--}}
{{--<ul class="fc-color-picker" id="color-chooser">--}}
{{--<li><a class="text-aqua" href="#" tag="*"><button type="button" class="btn btn-info" style="width:110px">@lang('view.Important Not Urgent')</button></a></li>--}}
{{--<li><a class="text-light-blue" href="#" tag="!"><button type="button" class="btn btn-danger" style="width:110px">@lang('view.Important Urgent')</button></a></li>--}}
{{--<li><a class="text-green" href="#" tag="^"><button type="button" class="btn btn-success" style="width:110px">@lang('view.Not Important Urgent')</button></a></li>--}}
{{--<li><a class="text-red" href="#" tag="~"><button type="button" class="btn btn-primary" style="width:110px">@lang('view.Not Important Not Urgent')</button></a></li>--}}
{{--<li></li>--}}
{{--,'style'=>'width: 150px;'--}}
{{--</ul>--}}
{{--<label for="drop-remove">--}}
{{--<input type="checkbox" id="drop-remove" checked >--}}
{{--@lang('view.remove after drop')--}}
{{--</label>--}}
{{--<div class="external-event bg-aqua" tasktype="1" >@lang('view.Plan')</div>--}}
</script>
@endsection
