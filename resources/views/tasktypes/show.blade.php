@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>

            @lang('view.Tasktype')@lang('view.show')
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('tasktypes.show_fields')
                    <a href="{!! route('tasktypes.index') !!}" class="btn btn-default">@lang('view.Back')</a>
                </div>
            </div>
        </div>
    </div>
@endsection
