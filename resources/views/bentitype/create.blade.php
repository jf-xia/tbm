{{--<style>--}}

    {{--.container{--}}
        {{--margin: 15px 15px;--}}
    {{--}--}}
    {{--.table tr  th{--}}
        {{--font-size: 14px;--}}
        {{--background: #c2ccd1;--}}
        {{--text-align: center;--}}
    {{--}--}}
    {{--.table tr  td{--}}
        {{--font-size: 14px;--}}
        {{--text-align: center;--}}
    {{--}--}}
    {{--.line{--}}
        {{--width: 100%;--}}
        {{--height: 2px;--}}
        {{--background: #468bab;--}}
        {{--margin-top:5px;--}}
    {{--}--}}
{{--</style>--}}
{{--<p>{{eval($data1)}}</p>--}}

{{--@extends('layouts.app')--}}

{{--@section('content')--}}
    {{--<section class="content-header">--}}
        {{--<h1>业务库管理类型新增</h1>--}}
        {{--<div class="line"></div>--}}

    {{--</section>--}}
    {{--<section class="container">--}}
        {{--<div>--}}

        {{--</div>--}}


    {{--</section>--}}

{{--@endsection--}}

        <!-- 新增弹出模型 -->
<div class="modal fade" id="addapp" tabindex="-1" role="dialog" aria-labelledby="addappLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="addappLabel">新增app信息1</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group" id="addapp-content">
                        <form  id="addapp-form" method="post" >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="aapp_sku" value="{{ Request::segment(3) }}">
                            <input type="hidden" name="aapp_create_date" id="aapp_create_date" value="{{ date("Y-m-d") }}">
                            <input type="hidden" name="aapp_create_user" id="aapp_create_user" value=" {{  Auth::user()->id }}">
                            <input type="hidden" name="aapp_modify_user" id="aapp_modify_user" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="aapp_modify_date" id="aapp_modify_date" value="{{ date("Y-m-d") }}">
                            <label>环境：</label><select name="aapp_env" id="aapp_env" class="form-control">

                            </select>
                            <label>应用类型：</label><select class="form-control" type="text" name="aprod_type" id="aprod_type" >

                            </select>
                            <label>服务器IP：</label><input class="form-control" type="text" name="web_ip" id="web_ip" required>
                            <label>应用端口号：</label><input class="form-control" type="text" name="web_port" id="web_port" required>
                            <label>描述：</label><textarea class="form-control" type="text" name="prod_desc" id="prod_desc" ></textarea>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button  class="btn btn-primary">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
