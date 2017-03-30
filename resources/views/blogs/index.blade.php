@extends('blogs.app')

@section('css')
    <title>@lang('view.FOCUS Blog') @lang('view.- focus on time management & sharing experience, attention to guiding teaching & learning, cultivate good habits & quality brand')</title>
    <link rel="stylesheet" href="{{ URL::asset('vendor/jsmind/css/jsmind.css') }}">
@endsection

@section('content')
    @include('blogs.header')
    <div class="row">
        <div class="clearfix"></div>
        <div class="col-md-12" >
        <div class="col-md-3 fullhide" >
            <div class="sidebar-module sidebar-module-inset">
                <h4>@lang('view.Tag')</h4>
                {!! $tagHtml !!}
            </div>
        </div>
        <div class="col-md-9 fullshow">
            <div id="jsmind_container" style="height: 200px;" onclick="$('.jsmind-toolbar').toggle()"></div>
            <div class="jsmind-toolbar" style="display: none;" >
                <button id="zoom-in-button" class="fa fa-plus" onclick="zoomIn();"></button>
                <button id="zoom-out-button" class="fa fa-minus" onclick="zoomOut();"></button>
                <button class="fa fa-floppy-o" onclick="jmsave();"></button>
                <button class="fa fa-arrows-alt" onclick="$('.fullhide').hide();$('.fullshow').addClass('col-md-12');$('.fullshow').removeClass('col-md-9');$('#jsmind_container').attr('style','height:600px');jm.resize();jm.expand_all();"></button>
            </div>
        </div>
        </div>
        <div class="clearfix"></div><hr/>
        <div class="col-md-12" >
        @foreach($posts as $post)
            <div class="col-md-3" >
                <div class="blog-post" >
                    <h3 title="{{ $post->title }}">{{ $post->title }}</h3>
                    <p class="post">{{ mb_substr(strip_tags($post->content),0,130)  }}</p>
                    <p><i>By <a href="{{ route('index.user',$post->user_id) }}">{{ $post->user->name }}</a> At {{ $post->created_at->format('Y-m-d') }}</i></p>
                    <p><a class="btn btn-default" href="{{ route('index.post',$post->id) }}" role="button">@lang('view.View details') »</a></p>
                </div>
            </div>
        @endforeach
            <div class="clearfix"></div>
            {{ $posts->render() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ URL::asset('vendor/jsmind/js/jsmind.js') }}"></script>
    <script src="{{ URL::asset('vendor/jsmind/js/jsmind.draggable.js') }}"></script>
    <script type="text/javascript">
        function load_jsmind(){
            var mind = {
                "meta":{
                    "name":"LearnShare",
                    "author":"289630310@qq.com",
                    "version":"1.0",
                },
                "format":"node_array",
                "data": {!! $tags !!}
            };
            var options = {
                container:'jsmind_container',
                editable:true,
                theme:'primary',
                mode :'full',           // 显示模式
                support_html : true,    // 是否支持节点里的HTML元素
//                view:{
//                    hmargin:100,        // 思维导图距容器外框的最小水平距离
//                    vmargin:50,         // 思维导图距容器外框的最小垂直距离
//                    line_width:2,       // 思维导图线条的粗细
//                    line_color:'#555'   // 思维导图线条的颜色
//                },
                layout:{
                    hspace:20,          // 节点之间的水平间距
                    vspace:10,          // 节点之间的垂直间距
                    pspace:13           // 节点收缩/展开控制器的尺寸
                },
                shortcut:{
                    enable:true,        // 是否启用快捷键
                    handles:{},         // 命名的快捷键事件处理器
                    mapping:{           // 快捷键映射
                        addchild   : 45,    // <Insert>
                        addbrother : 13,    // <Enter>
                        editnode   : 113,   // <F2>
                        delnode    : 46,    // <Delete>
                        toggle     : 32,    // <Space>
                        left       : 37,    // <Left>
                        up         : 38,    // <Up>
                        right      : 39,    // <Right>
                        down       : 40,    // <Down>
                    }
                },
            }
            jm = jsMind.show(options,mind);
            // jm.set_readonly(true);
            // var mind_data = jm.get_data();
            // alert(mind_data);
        }
        var jm;
        load_jsmind();
        jm.expand_to_depth(1);

        $("jmnode").mouseover(function(){
            var nodeid = $(this).attr('nodeid');
            if ($.isNumeric(nodeid) && nodeid >0) {
//                console.log($('#jmnode-' + nodeid).size());
                if ($('#jmnode-' + nodeid).size() > 0) {
                    $('#jmnode-' + nodeid).show();
                } else {
                    var linkBotton = '<a href="' + '{{ url('sort/price') }}/' + nodeid + '" id="jmnode-' + nodeid + '" class="fa fa-eye ico" style="color: #FFF;" > </a>';
                    $(this).prepend(linkBotton);
                }
            }
        }).mouseout(function(){
            $('#jmnode-'+$(this).attr('nodeid')).hide();
        });


        {{--$("jmnode").click(function(){--}}
            {{--var nodeid = $(this).attr('nodeid');--}}
            {{--console.log(typeof nodeid);--}}
            {{--if ($.isNumeric(nodeid) && nodeid >0){--}}
                {{--window.location.href = '{{ url('sort/price') }}/' + nodeid;--}}
            {{--}--}}
        {{--});--}}

        var zoomInButton = document.getElementById("zoom-in-button");
        var zoomOutButton = document.getElementById("zoom-out-button");

        function zoomIn() {
            if (jm.view.zoomIn()) {
                zoomOutButton.disabled = false;
            } else {
                zoomInButton.disabled = true;
            };
        };

        function zoomOut() {
            if (jm.view.zoomOut()) {
                zoomInButton.disabled = false;
            } else {
                zoomOutButton.disabled = true;
            };
        };

        function jmsave(){
            var mind_data = jm.get_data('node_array');
            var mind_string = jsMind.util.json.json2string(mind_data);
//            alert(mind_string);

            $.ajax({
                url: '{{ route('tasks.tagupdate') }}', type: 'POST',
                data: { jsondata:mind_data },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                },
                success: function(doc) {
                    if(doc==1) {
                        alert('保存成功!');
                    } else {
                        alert('无更新权限!');
                    }
                }
            });
        }
    </script>
@endsection