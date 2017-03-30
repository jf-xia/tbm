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

                <img src="{{  URL::asset('images/intro/intro_1.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_2.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_3.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_4.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_5.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_6.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_7.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_8.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_9.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_10.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_11.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_12.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_13.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_14.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_15.jpg') }}" width="60%"  />
                <img src="{{  URL::asset('images/intro/intro_16.jpg') }}" width="60%"  />

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
