@extends('layouts.app')
<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
@section('content')
    <section class="content-header">
        <h1 class="pull-left">业务库管理类型</h1>
        <h1 class="pull-right">
            <button class="btn btn-primary dropdown-toggle "  data-toggle="modal" data-target="#addapp" style="margin-top: -10px;margin-bottom: 5px"  type="button" data-toggle="dropdown" >
                新增<span class="caret"></span>
            </button>

        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                {{--@include('tasks.table')--}}

                    <table class="table table-hover" id="tab">
                        <tr>
                            <th>序号</th>
                            <th>名称</th>
                            <th>内容</th>
                            <th>操作</th>

                        </tr>
                        <?php
                        $num=0;
                        $d=$data1;

                        foreach($d as $bentity){

                        $num++;
                        ?>
                        <tr style="font-size: 14px;">
                            <td><?php echo $num;?></td>
                            <td style="display: none">{{$bentity->id}}</td>
                            <td>{{ $bentity->name}}</td>
                            <td>{{ $bentity->context}}</td>
                            {{--<td><a href="{!!route('bentitype.create')!!} "> 新增</a><a href="#"> 编辑</a><a href="#"> 删除</a></td>--}}
                            <td id="action"><a href="{!! route('bentitype.edit',$bentity->id) !!}"  class="btn btn-default btn-xs edit" title="编辑"><i class="glyphicon glyphicon-edit" ></i></a>

                                {!! Form::open(['route' => ['bentitype.destroy', $bentity->id], 'method' => 'DELETE']) !!}

                                <button id='delbtn'type="submit" title="删除" onclick="return confirm('确定要删除吗?');" class="btn btn-danger btn-xs" ><i class="glyphicon glyphicon-trash"></i></button>

                                {!!  Form::close() !!}
                            </td>

                     </tr>
                        <?php
                        }
                        ?>
                    </table>
                <hr style="border: 1px solid lightsteelblue">

            </div>
        </div>
    </div>
@endsection
@include('bentitype.js')
@include('bentitype.model')
<style>

    #action a, #action button{
        display: inline-block;
        float: left;
    }

</style>



