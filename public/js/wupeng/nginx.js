/**
 * Created by peng.wu2 on 2016/10/27.
 */
$(document).ready(function(){

    var base_url = $(location).attr('href').split("/").splice(0, 5).join("/")+"/nginx";
    $("#addproxy").click(function () {
        $("#addproxyhtml").modal("show");
    });
    var nginxtab = $('#nginxtab').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        "ajax":{
            url :base_url+"/_list",
        },
        aoColumnDefs:[{
            targets: 5,
            render: function (data, type, row) {
                html =  '<div class="form-horizontal form-group">' +
                    '<div class="col-xs-4"><button  id="editrow" style="width: 60px" class="btn btn-primary"  >修改</button></div>' +
                    '<div class="col-xs-4"><button  id="deleterow"  style="width: 60px" class="btn btn-danger "   >删除</button></div>';
                return html;
            }
        }],
        "language":{
            "sProcessing":   "处理中...",
            "lengthMenu": "_MENU_ 条记录每页",
            "paginate": {
                "previous": "上一页",
                "next": "下一页"
            },
            "info": "第 _PAGE_ 页 ( 总共 _PAGES_ 页 )",
            "infoEmpty": "无记录",
            "infoFiltered": "(从 _MAX_ 条记录过滤)",
            "search":"查询",
        },
    });
    $("#address").change(function(){
        var address = $("#address option:selected").attr('value');
        if(address == '蛇口'){
            $("#public_ip").val("119.147.213.31");
            $("#proxy_server").val("10.228.3.26");
        }
        else if(address == '南山'){
            $("#public_ip").val("210.75.17.216");
            $("#proxy_server").val("10.1.134.60");
        }
        else {
            $("#public_ip").val("请选择机房");
        }
    });
    $('#addproxy-form').submit(function(e){
        $(":submit",this).attr("disabled","disabled");
        e.preventDefault();
        $.ajax({
                url :base_url+"/create",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#addproxy_content').fadeOut('slow', function(){
                    $('#addproxy_content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('submit failed');
            });
    });

    //edit
    $('#nginxtab tbody').on( 'click', 'button#editrow', function () {
        var data = nginxtab.row( $(this).parents('tr') ).data();
        $("#editproxyhtml").modal("show");
        $('#eid').val(data[6]);
        $('#edomain').val(data[0]).attr('readonly','readonly');
        $('#esource').val(data[1]);
        $('#old_source').val(data[1]);
        $('#eaddress').val(data[2]).attr('disabled',true);
        $('#epublic_ip').val(data[3]);
        $('#eproxy_server').val(data[5]);
    });

    $('#editproxy-form').submit(function(e){
        $(":submit",this).attr("disabled","disabled");
        e.preventDefault();
        $.ajax({
                url :base_url+"/update",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#editproxy_content').fadeOut('slow', function(){
                    $('#editproxy_content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('submit failed');
            });
    });

    //delete
    $('#nginxtab tbody').on( 'click', 'button#deleterow', function () {
        var data = nginxtab.row( $(this).parents('tr') ).data();
        $("#deleteproxyhtml").modal("show");
        $('#did').val(data[6]);
        $('#delete_domain').html(data[0]);
        $('#ddomain').val(data[0]);
        $('#dproxy_server').val(data[5]);
    });

    $('#deleteproxy-form').submit(function(e){
        $(":submit",this).attr("disabled","disabled");
        e.preventDefault();
        $.ajax({
                url :base_url+"/delete",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#deleteproxy_content').fadeOut('slow', function(){
                    $('#deleteproxy_content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('submit failed');
            });
    });



})
