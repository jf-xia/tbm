@extends('layouts.app')
<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>

<style>

    #show{
        position: relative;
        font-weight: bold;
    }

    #search{
        position: absolute;
        right: 20px;
        top:20px;
    }
    #search input{
        border: 1px solid lightgrey;
        border-radius:3px;
        height:30px;
    }
    #con table{
        font-size: 14px !important;
    }
    #actiontab a{
        position: absolute;
        top: 25px;
        right:20px;
    }
 #show li{
        position: relative;
        padding:5px 15px;
    }
    #editbtn{
        position: absolute;
        top: 10px;
        right:2px;
    }
    #delbtn{
        position: absolute;
        top: 30px;
        right:2px;
    }
    #delbtn i{
        padding-left:0px;
    }

    .deledit .deleditdiv{
        display: none;
    }
    .deledit:hover .deleditdiv{
        display: block;

    }

    #con tr td:last-child:hover a{
        background:lightgrey;
    }
</style>
@section('content')
    <section class="content-header" style="height: 40px">
        <h1 class="pull-left">业务汇总列表</h1>
        <div id="actiontab">
            <a class="btn btn-primary pull-right" style="margin-top: -10px;margin-bottom: 5px" href="{!!route("bentity.create") !!}">新增业务库类型</a>
        </div>
    </section>

    <div class="content">

        <div class="box box-warning">

            <div class="box-body">

                <div class="row">
                    <div class="col-md-12">
                        {{--tab导航--}}
                        <div class="nav-tabs-custom" id="navtab">
                            <ul class="nav nav-tabs" id="show">

                                <div  id="search" class="input-group col-sm-3">
                                    {!! Form::text('searchtitle',isset(Request::all()['search']) ? Request::all()['search']:'',['id'=>'searchtitle','class'=>'form-control','placeholder'=>'主题']) !!}
                                    <span class="input-group-btn" onclick="javascript:if($('#searchtitle').val()!==''){window.location.href='{{ route('bentity.lists',[$id ? $id : 0,$benId ? $benId : 0]) }}?search='+$('#searchtitle').val();}">
                                     <button class="btn btn-default" type="button">@lang('view.Search')</button></span>

                                </div>
                                @foreach ($bentity as $ben )
                                    <li class="deledit @if($ben->tasktypes_id==$id) active @endif" ><a href="{!!route("bentity.lists",[$ben->tasktypes_id,$ben->id]) !!}" >{{$ben->name}}</a>
                                        <div class="deleditdiv">
                                            <a href="{!! route('bentity.edit',$ben->id) !!}" id="editbtn" class="btn btn-default btn-xs edit" title="编辑"><i class="glyphicon glyphicon-edit" ></i></a>

                                            {!! Form::open(['route' => ['bentity.destroy', $ben->id], 'method' => 'DELETE']) !!}
                                            <button id='delbtn'type="submit" title="删除" onclick="return confirm('确定要删除吗?');" class="btn btn-danger btn-xs" ><i class="glyphicon glyphicon-trash"></i></button>
                                            {!!  Form::close() !!}
                                        </div>



                                    </li>
                                @endforeach
                            </ul>

                        </div>
                        <div >


                                <div  id="con">
                                    <table  class="table table-hover table-bordered">
                                        <thead>
                                        <tr>
                                            <th>主题</th>
                                            <th>创建时间</th>
                                            <th>更新时间</th>
                                            <th>处理时间</th>
                                            <th>操作</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {{--循环显示里面数据--}}
                                        @foreach ($task as $tt )
                                            <tr>
                                                <td >{{$tt->title}}</td>
                                                <td>{{ $tt->created_at }}</td>
                                                <td>{{ $tt->updated_at }}</td>
                                                <td>{{ $tt->end_at }}</td>

                                                {{--此处id为task_type_id--}}
                                                <td><a href="{!! route('bentity.detail',[$tt->id,$benId,$id]) !!}" target="_blank" class="btn btn-default btn-xs">

                                                        <i class="glyphicon glyphicon-eye-open" style="padding: 4px 2px"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                    {!! $task->render() !!}
                                </div>


                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
@endsection
@section('scripts')
    @include('bentity.model')
@endsection
<script>
    window.onload=function(){
//        $(" #show li ").click(function(){
//            $(this).addClass("active").siblings().removeClass("active");
//
//        });
//        $(" #test ").click(function(){
//            $(this).addClass("active");
//
//        });
    }

</script>