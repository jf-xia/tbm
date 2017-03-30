@extends('layouts.errors')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">{{ $error }}@lang('view.Error! Page not found.')</h1>
    </section>
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red">{{ $error }}</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> @lang('view.Error! Page not found.')</h3>

                <p>
                    @lang('view.The page you entered was not found!')<a href="{{ url('/') }}" >@lang('view.Back home')</a> | <a href="javascript:history.back()" >@lang('view.Return to previous step')</a>.<br>
                    @lang('view.If you have any questions, please contact system administrator: Task.system@gtafe.com')
                </p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
@endsection
