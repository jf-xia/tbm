<html><head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/blog.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('vendor/select2/css/select2-bootstrap.min.css') }}">
    @yield('css')

</head><body>
<div class="blog-masthead">
    <nav class="blog-nav">
        <a class="blog-nav-item" href="{{ route('index.index') }}">
            <b>@lang('view.Home')</b>
        </a>
        <a class="blog-nav-item" href="{{ route('index.sort','price') }}">
            <b>@lang('view.Hot Post')</b>
        </a>
        <a class="blog-nav-item" href="{{ route('index.sort','created_at') }}">
            <b>@lang('view.New Post')</b>
        </a>
        @yield('menus')
        @if(Auth::check())
            <a class="blog-nav-item" href="{{ route('index.user',Auth::id()) }}">
                <b>@lang('view.About')</b>
            </a>
            <a class="blog-nav-item" href="{{ route('tasks.calendar') }}">
                <b>@lang('view.My Dashboard')</b>
            </a>
            <a class="blog-nav-item fa fa-search pull-right" href="javascript:$('.search-poster').toggle()">
                <b>@lang('view.Search')</b>
            </a>
            <div class="search-poster pull-right" style="display: none;" >
                {!! Form::text('s', null, ['class' => 'form-control','placeholder'=>trans('view.Search').trans('view.Posts').' & Enter','onkeydown'=>"if(event.keyCode==13){window.location.href='".url('')."/sort/price/0/'+$(this).val();}"]) !!}
                {!! Form::select('assigned_to',[],  null, ['class' => 'select2-ajax-users','onchange'=>"window.location.href='".url('')."/'+$(this).children('option:selected').val();"]) !!}
            </div>
        @else
            <a class="blog-nav-item" href="{{ route('login') }}">
                <b>@lang('view.Login')</b>
            </a>
        @endif
    </nav>
</div>
<div class="container">
    @yield('content')
</div>

<footer class="blog-footer">
    <p>TBM by Jianfeng Xia.</p>
    <p>
        <a href="#">Back to top</a>
    </p>
</footer>


<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<script src="{{ URL::asset('vendor/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('vendor/select2/js/i18n/zh-CN.js') }}"></script>
@include('layouts.select2_js')
<script type="text/javascript">
    select2(".select2-ajax-users", "/tasks/usersajaxlist",false,'@lang('view.User')');
</script>
@yield('scripts')
</body></html>