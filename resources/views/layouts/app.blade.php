<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>@lang('view.TBM')</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/gta.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/intro/css/introjs.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ URL::asset('css/ionicons.min.css') }}">

    @yield('css')
    @include('UEditor::head')
</head>

<body class="skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ url('') }}" class="logo">
                <b>TBM</b>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <?php
                    $routerName = \Route::current()->getName();
                    $hasHelp = $routerName && View::exists('intro.'.$routerName);
                    ?>
                    <ul class="nav navbar-nav">
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="font-size: 18px;">
                                    <i class="fa fa-question-circle-o fa-4" aria-hidden="true" ></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            @if($hasHelp)
                                            <li>
                                                <a href="#" onclick="javascript:help();" >
                                                    @lang('view.Current page Function Wizard')
                                                </a>
                                            </li>
                                            @endif
                                            <li>
                                                <a href="{{ route('intro.index') }}">
                                                    @lang('view.System Function Wizard')
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">3</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">@lang('view.You have') 3 @lang('view.notifications')</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><a href="{{ url('taskgroups/type').'/5' }}">
                                                <i class="fa fa-star text-red"></i>@lang('view.Team have')
                                                {!! \App\Models\Taskgroup::where('user_id','=',\Auth::id())->count() !!} @lang('view.All Task')</a></li>
                                        {{--<li><a href="{{ url('taskgroups/type').'/1' }}">--}}
                                                {{--<i class="fa fa-users text-aqua"></i>@lang('view.Team have')--}}
                                                {{--{!! \App\Models\Taskgroup::whereNotNull('task_id')->where('user_id','=',\Auth::id())->count() !!} @lang('view.Sub Task')</a></li>--}}
                                        {{--<li><a href="{{ url('taskgroups/type').'/2' }}">--}}
                                                {{--<i class="fa fa-comments-o text-green"></i>@lang('view.Team have')--}}
                                                {{--{!! \App\Models\Taskgroupview::where('grade','=',0)->where('taskstatus_id','=',5)->count() !!} @lang('view.Uncommented Task')</a></li>--}}
                                        <li><a href="{{ url('taskgroups/type').'/3' }}">
                                                <i class="fa fa-thumbs-o-up text-blue"></i>@lang('view.Team have')
                                                {!! \App\Models\Taskgroup::where('grade','=',1)->where('user_id','=',\Auth::id())->count() !!} @lang('view.Good Task')</a></li>
                                        <li><a href="{{ url('taskgroups/type').'/4' }}">
                                                <i class="fa fa-frown-o text-orange"></i>@lang('view.Team have')
                                                {!! \App\Models\Taskgroup::where('grade','=',2)->where('user_id','=',\Auth::id())->count() !!} @lang('view.Bad Task')</a></li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="{{ route('taskgroups.index') }}">@lang('view.View all')@lang('view.Taskgroup')</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <?php
                                $tasks = \App\Models\Task::where('taskstatus_id','<>',5)->where('user_id','=',\Auth::id());
                                $tasksCount = $tasks->count();
                            ?>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">{{ $tasksCount }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">@lang('view.You have') {{ $tasksCount }} @lang('view.Task')@lang('view.Unfinished')</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        @foreach($tasks->get() as $task)
                                        <li><!-- Task item -->
                                            <a href="{{ route('tasks.show',$task->id) }}">
                                                <h3>
                                                    [{{ $task->tasktype_name }}] {{ $task->title }}
                                                    <small class="pull-right">{{ $task->taskstatus_name }}</small>
                                                </h3>
                                            </a>
                                        </li>
                                        @endforeach
                                        <!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="{{ route('tasks.index') }}">@lang('view.View all')@lang('view.Task')</a>
                                </li>
                            </ul>
                        </li>

                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ URL::asset('images/blue_logo_150x150.jpg') }}"
                                     class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ URL::asset('images/blue_logo_150x150.jpg') }}"
                                         class="img-circle" alt="User Image"/>
                                    <p>
                                        {!! Auth::user()->name !!}
                                        {{--<small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>--}}
                                        <small>@lang('view.Uncommented Task'){{ Auth::user()->like[0] }}/
                                            @lang('view.Good Task'){{ Auth::user()->like[1] }}/
                                            @lang('view.Bad Task'){{ Auth::user()->like[2] }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('tasks.editmyself') }}" class="btn btn-default btn-flat">@lang('view.Profile')</a>
                                    </div>
                                    <div class="pull-left">
                                        <a href="{{ route('index.user',Auth::id()) }}" class="btn btn-default btn-flat">@lang('view.Resume')</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            @lang('view.Sign out')
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2016 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div>

    <!-- jQuery 2.1.4 -->
    <script src="{{ URL::asset('js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('js/icheck.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/select2/js/i18n/zh-CN.js') }}"></script>
    <script src="{{ URL::asset('vendor/intro/js/intro.js') }}"></script>
    <script src="{{ URL::asset('vendor/inputmask/inputmask.min.js') }}"></script>
    <script src="{{ URL::asset('vendor/inputmask/inputmask.date.extensions.js') }}"></script>
{{--    <script src="{{ URL::asset('vendor/inputmask/inputmask.extensions.min.js') }}"></script>--}}
    <script src="{{ URL::asset('vendor/inputmask/jquery.inputmask.min.js') }}"></script>

    @include('layouts.select2_js')
    @if($hasHelp)
        @include('intro.'.$routerName)
    @else
        <!-- {{ 'intro.'.$routerName }} -->
    @endif
    <script type="text/javascript">
//        $('.header').each(function(){ if($($(this).next()[0]).attr('class')=='header'||$(this).next().length==0){ $(this).hide(); } });
//        var AdminLTEOptions = {
//            sidebarExpandOnHover: true,
//            //Bootstrap.js tooltip
//            enableBSToppltip: true
//        };
        $(document).ready(function(){
            $(":input").inputmask();
        });
    </script>

    <!-- AdminLTE App -->
    <script src="{{ URL::asset('js/app.min.js') }}"></script>
    @yield('scripts')
</body>
</html>