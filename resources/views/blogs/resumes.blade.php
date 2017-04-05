@extends('blogs.app')

@section('css')
<title>{{ @$userresume['name'] }} - @lang('view.Resume')</title>
{{--<link rel="stylesheet" href="{{ URL::asset('css/blog.print.css') }}" media="print">--}}
@endsection

@section('content')
    <div class="row">
        @include('blogs.about')
        <hr />
        <div class="col-xs-12 col-sm-7">
            <!-- WORK EXPERIENCE -->
            <div class="box">
                <h2><i class="fa fa-suitcase ico"></i> @lang('view.Work Experience')</h2>
                <div class="job clearfix">
                    <div class="row">
                        <div class="job-details col-xs-11">
                            <div class="where"><span class="etext"  nid='{{ @$userresumeid['company'] }}' ntype="company" >{{ @$userresume['company'] }}</span>
                                - <span class="etext"  nid='{{ @$userresumeid['title'] }}' ntype="title" >{{ @$userresume['title'] }}</span>
                                <small>(<span class="etext"  nid='{{ @$userresumeid['work_from'] }}' ntype="work_from" >{{ @$userresume['work_from'] }}</span> -
                                    <span class="etext"  nid='{{ @$userresumeid['work_to'] }}' ntype="work_to" >{{ @$userresume['work_to'] }}</span>)</small></div>
                            <div class="description etextarea"  nid='{{ @$userresumeid['work'] }}' ntype="work" >{{ @$userresume['work'] }}</div>

                        </div>
                    </div>
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
            {{--<div class="box">--}}
                {{--<h2><i class="fa fa-line-chart ico"></i> 习惯养成</h2>--}}
                {{--<ul id="education" class="clearfix">--}}
                    {{--<li>--}}
                        {{--<div class="year pull-left etext" >6点</div>--}}
                        {{--<div class="description pull-right">--}}
                            {{--<h3 class="etext"  nid='{{ @$userresumeid['habits06'] }}' ntype="habits06" >{{ @$userresume['habits06'] }}</h3>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="year pull-left etext" >7点</div>--}}
                        {{--<div class="description pull-right">--}}
                            {{--<h3 class="etext"  nid='{{ @$userresumeid['habits07'] }}' ntype="habits07" >{{ @$userresume['habits07'] }}</h3>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="year pull-left etext" >12点</div>--}}
                        {{--<div class="description pull-right">--}}
                            {{--<h3 class="etext"  nid='{{ @$userresumeid['habits12'] }}' ntype="habits12" >{{ @$userresume['habits12'] }}</h3>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="year pull-left etext" >20点</div>--}}
                        {{--<div class="description pull-right">--}}
                            {{--<h3 class="etext"  nid='{{ @$userresumeid['habits20'] }}' ntype="habits20" >{{ @$userresume['habits20'] }}</h3>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="year pull-left etext" >21点</div>--}}
                        {{--<div class="description pull-right">--}}
                            {{--<h3 class="etext"  nid='{{ @$userresumeid['habits21'] }}' ntype="habits21" >{{ @$userresume['habits21'] }}</h3>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="year pull-left etext" >22点</div>--}}
                        {{--<div class="description pull-right">--}}
                            {{--<h3 class="etext"  nid='{{ @$userresumeid['habits22'] }}' ntype="habits22" >{{ @$userresume['habits22'] }}</h3>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                {{--</ul>--}}
            {{--</div>--}}
        </div>
    </div>
    <hr />
    {{--@if(Auth::check())--}}
        @include('blogs.calendar')
    {{--@endif--}}
@endsection

@section('scripts')
    <script src="{{ URL::asset('js/jquery.edittable.js') }}"></script>
    @yield('scripts_calendar')

    @if(Auth::id()==$id)
        <script type="text/javascript">
            $(document).ready(function() {

                $(".etext").each(function(){  if($(this).html().length<2){($(this).html($(this).html() + '@lang('view.Click to fill ')'+$(this).attr('ntype')))};  });
                $(".etextarea").each(function(){  if($(this).html().length<2){($(this).html($(this).html() + '@lang('view.Click to fill ')'+$(this).attr('ntype')))};  });

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
                        url: '{{ route('resumse.update_info') }}',
                        type: 'POST',
                        data: {
                            id: t.attr('nid'),
                            keyname: t.attr('ntype'),
                            content: data.current,
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            t.html(data.previous);
                            alert(errorThrown);
                        },
                        success: function(doc) {
                            t.attr('nid',doc);
                        }
                    });
                } else {
                    t.html(data.previous);
                }
            }
        </script>
    @endif
@endsection