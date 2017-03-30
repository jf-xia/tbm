<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ @$userresume['name'] }} - @lang('view.Resume')</title>
<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2-bootstrap.min.css') }}">
<link rel="stylesheet" media="print" href="{{ URL::asset('css/blog.print.css') }}">

</head><body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ url('') }}" class="logo">
                <b>@lang('view.Back') TBM</b>
            </a>
            {!! Form::select('assigned_to',[],  null, ['class' => 'select2-ajax-users','style'=>'width:200px','onchange'=>"window.location.href='".url('')."/'+$(this).children('option:selected').val();"]) !!}
            <div id="photo-header" class="text-center">
                <div id="photo">
                    <img src="{{ URL::asset(isset($userresume['picture']) ? $userresume['picture'] : 'images/blue_logo_150x150.jpg') }}" alt="avatar">
                </div>
                <div id="text-header">
                    <h1 class="etext"  nid='{{ @$userresumeid['name'] }}' ntype="name" >{{ @$userresume['name'] }}</h1>
                    <span class="etext"  nid='{{ @$userresumeid['label'] }}' ntype="label" >{{ @$userresume['label'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-7">
            <!-- ABOUT ME -->
            <div class="box">
                <h2><i class="fa fa-user ico"></i> @lang('view.About')</h2>
                <p class="etextarea"  nid='{{ @$userresumeid['summary'] }}' ntype="summary" >{{ @$userresume['summary'] }}</p>
                <p title="@lang('view.Fifty thousand meters - your values, principles and goals, this is the soul of your work')">
                    <strong>@lang('view.Principles'): </strong><span class="etextarea"  nid='{{ @$userresumeid['principle'] }}' ntype="principle" >{{ @$userresume['principle'] }}</span></p>
                <p title="@lang('view.Forty thousand M - 3~5 year goal, can be a position, can also be organizational capabilities, coordination, etc.')">
                    <strong>@lang('view.Vision'): </strong><span class="etextarea"  nid='{{ @$userresumeid['vision'] }}' ntype="vision" >{{ @$userresume['vision'] }}</span></p>
                <p title="@lang('view.Thirty thousand meters - more refined than the vision, usually a year of phased results')">
                    <strong>@lang('view.Aim'): </strong><span class="etextarea"  nid='{{ @$userresumeid['aim'] }}' ntype="aim" >{{ @$userresume['aim'] }}</span></p>
                <p title="@lang('view.Twenty thousand meters - the role of work, such as researcher, manager, etc.; the role of life, such as father and son, children, etc.')">
                    <strong>@lang('view.Duty'): </strong><span class="etextarea"  nid='{{ @$userresumeid['duty'] }}' ntype="duty" >{{ @$userresume['duty'] }}</span></p>
                <p title="@lang('view.Ten thousand meters - everything that needs to be done more than one step is a task')">
                    <strong>@lang('view.Task'): </strong><span class="etextarea"  nid='{{ @$userresumeid['task'] }}' ntype="task" >{{ @$userresume['task'] }}</span></p>
                <p title="@lang('view.The runway - all the minor details events, we will put all of them into the list, one by one to get things done')">
                    <strong>@lang('view.Actions'): </strong>@lang('view.See calendar for details. (need to Login, otherwise not visible)')</p>
            </div>
            <!-- WORK EXPERIENCE -->
            <div class="box">
                <h2><i class="fa fa-suitcase ico"></i> @lang('view.Work Experience')</h2>
                <div class="job clearfix">
                    <div class="row">
                        <div class="job-details col-xs-11">
                            <div class="where"><span class="etext"  nid='{{ @$userresumeid['company'] }}' ntype="company" >{{ @$userresume['company'] }}</span>
                                - (<span class="etext"  nid='{{ @$userresumeid['title'] }}' ntype="title" >{{ @$userresume['title'] }}</span>)</div>
                            <div class="description etextarea"  nid='{{ @$userresumeid['work'] }}' ntype="work" >{{ @$userresume['work'] }}</div>
                            <div class="year"><span class="etext"  nid='{{ @$userresumeid['work_from'] }}' ntype="work_from" >{{ @$userresume['work_from'] }}</span> -
                                <span class="etext"  nid='{{ @$userresumeid['work_to'] }}' ntype="work_to" >{{ @$userresume['work_to'] }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-5">
            <!-- CONTACT -->
            <div class="box clearfix">
                <h2><i class="fa fa-bullseye ico"></i> @lang('view.Contact')</h2>
                <div class="contact-item">
                    <div class="icon pull-left text-center"><span class="fa fa-map-marker fa-fw"></span></div>
                    <div class="title only pull-right etext"  nid='{{ @$userresumeid['address'] }}' ntype="address">{{ @$userresume['address'] }}</div>
                </div>
                <div class="contact-item">
                    <div class="icon pull-left text-center" >
                        <span class="fa fa-phone fa-fw " ></span>
                    </div>
                    <div class="title only pull-right etext"  nid='{{ @$userresumeid['phone'] }}' ntype="phone">{{ @$userresume['phone'] }}</div>
                </div>
                <div class="contact-item">
                    <div class="icon pull-left text-center"><span class="fa fa-envelope fa-fw"></span></div>
                    <div class="title only pull-right etext"  nid='{{ @$userresumeid['email'] }}' ntype="email">{{ @$userresume['email'] }}</div>
                </div>
                <div class="contact-item">
                    <div class="icon pull-left text-center"><span class="fa fa-globe fa-fw"></span></div>
                    <div class="title only pull-right etext"  nid='{{ @$userresumeid['website'] }}' ntype="website">{{ @$userresume['website'] }}</div>
                </div>
            </div>
            <!-- SKILLS -->
            <div class="box">
                <h2><i class="fa fa-tasks ico"></i> @lang('view.Skills')</h2>
                <p class="etextarea"  nid='{{ @$userresumeid['skills'] }}' ntype="skills" >{{ @$userresume['skills'] }}</p>
            </div>
            <div class="box">
                <h2><i class="fa fa-heart ico"></i> @lang('view.Interests')</h2>
                <div class="interests clearfix">
                    <p class="etextarea"  nid='{{ @$userresumeid['interests'] }}' ntype="interests" >{{ @$userresume['interests'] }}</p>
                </div>
            </div>
            <!-- EDUCATION -->
            <div class="box">
                <h2><i class="fa fa-university ico"></i> @lang('view.Education')</h2>
                <ul id="education" class="clearfix">
                    <li>
                        <div class="year pull-left etext"  nid='{{ @$userresumeid['edu_year'] }}' ntype="edu_year" >{{ @$userresume['edu_year'] }}</div>
                        <div class="description pull-right">
                            <h3 class="etext"  nid='{{ @$userresumeid['edu_university'] }}' ntype="edu_university" >{{ @$userresume['edu_university'] }}</h3>
                            <p><i class="fa fa-graduation-cap ico"></i>
                                <span class="etext"  nid='{{ @$userresumeid['edu_degree'] }}' ntype="edu_degree" >{{ @$userresume['edu_degree'] }}</span> - (
                                <span class="etext"  nid='{{ @$userresumeid['edu_sciences'] }}' ntype="edu_sciences" >{{ @$userresume['edu_sciences'] }}</span>)</p>
                            <p class="etextarea"  nid='{{ @$userresumeid['education'] }}' ntype="education" >{{ @$userresume['education'] }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@if(Auth::check())
    @include('blogs.calendar')
@endif

@yield('css')
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('js/jquery.edittable.js') }}"></script>
<script src="{{ URL::asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('vendor/select2/js/i18n/zh-CN.js') }}"></script>
@yield('scripts')
@include('layouts.select2_js')
<script type="text/javascript">
    select2(".select2-ajax-users", "/tasks/usersajaxlist");
</script>

@if(Auth::id()==$id)
<script type="text/javascript">
    $(document).ready(function() {

        $(".etext").each(function(){  if($(this).html()==''){($(this).html('@lang('view.Click to fill ')'+$(this).attr('ntype')))};  });
        $(".etextarea").each(function(){  if($(this).html()==''){($(this).html('@lang('view.Click to fill ')'+$(this).attr('ntype')))};  });

        $(".etext").editable({
            onSubmit:function(data){
                var t= $(this);
                ajaxstore(t,data);
            }
        });

        $(".etextarea").editable({
            type:"textarea",
            onSubmit:function(data){
                var t= $(this);
                ajaxstore(t,data);
            }
        });

//        $(".eselect").editable({
//            type:"select",
//            options:{'选项1':'值1','选21':'值2','选项3':'值3'},
//            onSubmit:function(data){
//                var t= $(this);
//                if(confirm("真的要修改吗？")){
//                    alert(data.current);
//                }else{
//                    t.html(data.previous);
//                }
//            }
//        });
    });

    function ajaxstore(t,data){
        if(data.current !== data.previous && data.current!==''){
            $.ajax({
                url: '{{ route('tasks.update_info') }}',
                type: 'POST',
                data: {
                    id: t.attr('nid'),
                    keyname: t.attr('ntype'),
                    content: data.current,
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    t.html(data.previous);
                    alert(errorThrown);
//                        },
//                        success: function(doc) {
//                            alert(doc);
                }
            });
        } else {
            t.html(data.previous);
        }
    }
</script>
@endif
</body></html>