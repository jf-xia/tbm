@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">403 @lang('view.Error! No permission')</h1>
    </section>
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-red">403</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> @lang('view.Sorry'), @lang('view.Error! No permission')</h3>

                <p>
                    @lang('view.You do not have permission!')<a href="{{ url('/') }}" >@lang('view.Back home')</a> | <a href="javascript:history.back()" >@lang('view.Return to previous step')</a><br>
                    @lang('view.If you have any questions, please contact system administrator: Task.system@gtafe.com')
                </p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
@endsection

