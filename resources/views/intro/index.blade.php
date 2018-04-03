@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">@lang('view.Intro')</h1>
        <h1 class="pull-right"></h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body" style="text-align: center">


           </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function help(){
            //menu和header的help提示

            $(".navbar-custom-menu ul li").eq(1).attr({"data-step":"11","data-intro":"1.您的团队任务提醒<br>2.被点赞或吐槽任务提醒"});
            $(".tasks-menu").attr({"data-step":"12","data-intro":"您未处理完成的任务提醒"});
            introJs().start();
        }
    </script>
@endsection
