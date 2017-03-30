@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">@lang('view.Taskgroups')</h1>
        <h1 class="pull-right">
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <?php
                    //dd(\App\Models\Taskgroupview::all())
                ?>
                    @include('taskgroups.table')
            </div>
        </div>
    </div>
@endsection

