

{{--<div class="container moredetail">--}}
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <div class="box box-primary">
                <h2><i class="fa fa-check-square ico"></i> @lang('view.Calendar')</h2>
                <input id="user_id" type="hidden" value="{{ $id }}">
                <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        @include('blogs.posts')
    </div>
{{--</div>--}}


@section('scripts_calendar')
<!-- fullCalendar 2.2.5 -->
<link rel="stylesheet" href="{{ URL::asset('vendor/fullcalendar/fullcalendar.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/fullcalendar/fullcalendar.print.css') }}" media="print">
<script src="{{ URL::asset('js/jquery-ui.min.js') }}"></script>
<script src="{{ URL::asset('vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendor/fullcalendar/fullcalendar.min.js') }}"></script>
<script src='{{ URL::asset('vendor/fullcalendar/locale/zh-cn.js') }}'></script>
<!-- Page specific script -->
<script>
    $(function () {
        /* initialize the calendar */
        var date = new Date();
        var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear();
        $('#calendar').fullCalendar({
            minTime: "06:00:00",
            maxTime: "24:00:00",
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay,listWeek'//,listMonth  timelineDay
            },
            navLinks: true,
            displayEventTime: false,
            weekNumbers: true,
//            scrollTime: '00:00',
//            businessHours: true,
            eventLimit: true,
            events: function(start, end, timezone, callback) {
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
//                        alert(errorThrown);
                    },
                    success: function(doc) {
                        var events = [];
                        $(doc).each(function() {
                            var borderColor = '#ff0000';
                            if ($(this).attr('taskstatus')==5){
                                var borderColor = '#fff';
                            }
                            events.push({
                                id: $(this).attr('id'),
                                title: $(this).attr('title'),
                                start: $(this).attr('startat'), // will be parsed
                                end: $(this).attr('endat'),
                                url: '/tasks/'+$(this).attr('id'),
                                backgroundColor: $(this).attr('color'),
                                allDay: $(this).attr('allday'),
                                borderColor: borderColor
                            });
                        });
                        callback(events);
                    }
                });
//                cache: true
            },
            eventClick: function(event) {
                // opens events in a popup window
                window.open(event.url);
                return false;
            },
            editable: false,
        });

    });
</script>
@endsection
