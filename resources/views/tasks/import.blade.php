@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('vendor/upload/css/jquery.fileupload.css') }}">
@endsection

@section('content')
    <section class="content-header">
        <h1>
          @lang('view.Import')@lang('view.Task') - {{ $tasktype->name }}
            <a href="{!! route('tasks.index') !!}" class="btn btn-default">@lang('view.Back')</a>
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')


        <div class="completed-step">
            <a href="#"></a>
        </div>
        <div class="active-step">
            <a href="#"></a>
        </div>
        <div class="active-step">
            <a href="#"></a>
        </div>
        <div><a href="#"></a></div>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#Download" data-toggle="tab" ><span>1</span> @lang('view.Download') @lang('view.Import') @lang('view.Template')</a></li>
                <li><a href="#Edit" data-toggle="tab" ><span>2</span> @lang('view.Edit') @lang('view.Template') @lang('view.Data')</a></li>
                <li><a href="#Upload" data-toggle="tab" ><span>3</span> @lang('view.Upload') @lang('view.File')</a></li>
                <li><a href="#Import" data-toggle="tab" ><span>4</span> @lang('view.Data') @lang('view.Import')</a></li>
                <li><a href="#Check" data-toggle="tab" ><span>5</span> @lang('view.Check') @lang('view.Upload') @lang('view.Log')</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="Download">
                    <p><br>
                        当您想要导入任务数据时, 请先点击<a href="{!! route('tasks.importExample',$tasktype->id) !!}"> @lang('view.Download')@lang('view.Template')</a>
                        <br><br>
                        <h4>模板说明 & 注意事项:</h4>
                        <ul>
                            <li>导入行数建议不超过1000条，如果数量过多可能导致导入失败</li>
                            <li>模板的第一、二行为列名称, 不可修改或删除, 否则无法上传成功</li>
                            <li>模板的第二行为列的实际显示名称, 仅用于方便理解和填写数据, 不会导入系统, 该名称可以在分类管理中修改和添加</li>
                            <li>模板的第一列为上传编码, 必须为整数, 且建议不要重复, 可以是自增长编号, 这样更便于检查, 该列也不会导入系统</li>
                        </ul>
                    </p><br>
                    <button onclick="$('[href=\'#Edit\']').click();" class="btn btn-success" >
                        @lang('view.Next') - (@lang('view.Edit')@lang('view.Template')@lang('view.Data'))</button>
                </div>
                <div class="tab-pane" id="Edit">
                    <p><br>
                    <h4>当您已经 @lang('view.Download')@lang('view.Template'), 并开始填写数据时, 您需要注意数据填写规范:</h4>
                    <ul>
                        <li>id - 编号: 必填字段, 小于10位数</li>
                        <li>title - 主题: 必填字段, 长度不超过85个汉字或255个英文字符</li>
                        <li>created_at - 创建时间: 可选字段, 如果为空或格式错误则为当前导入时间</li>
                        <li>end_at - 处理时间: 必填字段, 且必须为时间格式, 例如: 2017-01-01</li>
                        <li>hours - 预计工时: 必填字段, 大于0且小于9</li>
                        <li>product_id - 关联产品: 当字段值为整数时, 默认关联系统ID, 当字段值为字符串时,默认关联产品编号, 当检查发现产品不存在时, 默认为0, 并发出警告</li>
                        <li>project_id - 所属项目: 当字段值为整数时, 默认关联系统ID, 当字段值为字符串时,默认关联项目编号, 当检查发现项目不存在时, 默认为0, 并发出警告</li>
                        <li>content - 详情: 选填字段, 可填写大文本数据</li>
                        <li>其他属性字段: 默认选填, 这些字段来自您当前的任务类型中设置好的字段, 可在分类管理中修改</li>
                    </ul>
                    </p><br>
                    <button onclick="$('[href=\'#Upload\']').click();" class="btn btn-success" >
                        @lang('view.Next') - (@lang('view.Upload')@lang('view.File'))</button>
                </div>
                <div class="tab-pane" id="Upload">
                    <br>
                    <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-success fileinput-button">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>@lang('view.Select')@lang('view.File')@lang('view.Upload')</span>
                                <!-- The file input field used as target for the file upload widget multiple -->
                                <input id="fileupload" type="file" name="files" >
                            </span>
                    <br>
                    <br>
                    <!-- The global progress bar -->
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <!-- The container for the uploaded files -->
                    <div id="files" class="files"></div>
                    <br>
                    <ul>
                        <li>@lang('view.The maximum file size for uploads is') <strong>{{ini_get("upload_max_filesize")}} </strong> </li>
                        <li>@lang('view.The file type should be') <strong>Excel (xls/xlsx) </strong> </li>
                    </ul>
                    <button onclick="$('[href=\'#Import\']').click();" class="btn btn-success hide next-import" >
                        @lang('view.Next') - (@lang('view.Import')@lang('view.Data'))</button>
                </div>
                <div class="tab-pane" id="Import">
                    <div id="check-data"></div>
                    <p>如果您确认数据无误, 请点击提交按钮</p>
                    <button onclick="submitimport()" class="btn btn-warning hide next-submit" type="button">@lang('view.Submit')@lang('view.Import')</button>
                </div>
                <div class="tab-pane" id="Check">
                    <div id="check-log"></div>
                </div>
                <input type="hidden" id="file-name" value="" />
            </div>
            <!-- /.tab-content -->
        </div>

        <div class="clearfix"></div>
        <h3>@lang('view.Import')@lang('view.History')@lang('view.Log')</h3>
        <div class="box box-primary">
            <div class="box-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@lang('db.file_name')</th>
                        <th>@lang('db.upload_ids')</th>
                        <th>@lang('db.import_ids')</th>
                        <th>@lang('db.error_ids')</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($uploads as $file)
                        <tr>
                            <td>{{ $file->file_name }}</td>
                            <td title="{{ $file->upload_ids }}">{{ substr(strip_tags($file->upload_ids),0,30) }}</td>
                            <td title="{{ $file->import_ids }}">{{ substr(strip_tags($file->import_ids),0,30) }}</td>
                            <td title="{{ $file->error_ids }}">{{ substr(strip_tags($file->error_ids),0,30) }}</td>
                            <td><a class="btn btn-danger" href="{{ URL::route('tasks.deleteimport', $file->id) }}">@lang('view.Delete')</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ URL::asset('vendor/upload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('vendor/upload/js/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('vendor/upload/js/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('vendor/upload/js/vendor/jquery.ui.widget.js') }}"></script>
    <script>
        function submitimport(){
            $.get('{{ route('tasks.submitimport') }}',
                    { tid:'{{ $tasktype->id }}',file:$('#file-name').val() },
                    function(result){
                        $('#check-log').html(
                                '<p>已上传全部编号: '+result.upload_ids+'</p>'+
                                '<p>上传失败的编号: '+result.error_ids+'</p>'+
                                '<p>已导入任务编号: '+result.import_ids+'</p>'
                        );
                        $("[href='#Check']").click();
                    }
            );
        }
        /*jslint unparam: true */
        /*global window, $ */
        $(function () {
            'use strict';
            // Change this to the location of your server-side upload handler:
            var url = '{{ route('tasks.upload') }}';

            $('#fileupload').fileupload({
                url: url,
                dataType: 'json',
                progressall: function (e, data) {
                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('#progress .progress-bar').css(
                            'width',
                            progress + '%'
                    );
                }
            }).on('fileuploaddone', function (e, data) {
//                console.log(data.result.files,e);
                $.each(data.result.files, function (index, file) {
                    if (file.url) {
                        $('#files').html(file.name+' @lang('view.Upload')@lang('view.Success')');
                        $('.next-import').removeClass('hide');
                        $('.next-submit').removeClass('hide');
                        $('#file-name').val(file.name);
                        $.get('{{ route('tasks.checkimport') }}', { tid:'{{ $tasktype->id }}',file:file.name },
                                function(result){$('#check-data').html(result);});
                    } else if (file.error) {
                        var error = $('<span class="text-danger"/>').text(file.error);
                        $('#files').html(error);
                    }
                });
            }).prop('disabled', !$.support.fileInput)
                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
        });
    </script>
@endsection