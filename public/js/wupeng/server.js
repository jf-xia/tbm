/**
 * Created by peng.wu2 on 2016/10/27.
 */

$(document).ready(function(){
    var base_url = $(location).attr('href').split("/").splice(0, 5).join("/");
    var tables = $('#server').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "ajax":{
                url :window.location.pathname+"/_list",
            },
            "aoColumns": [          //设置各列的宽
                {"sWidth": "60px"},
                {"sWidth": "30px"},
                {"sWidth": "30px"},
                {"sWidth": "70px"},
                {"sWidth": "20px"},
                {"sWidth": "30px"},
                {"sWidth": "30px"},
                {"sWidth": "75px"},
                {"sWidth": "50px"},
                {"sWidth": "70px"},
                {"sWidth": "180px"}
            ],
        aoColumnDefs:[{
                targets: 10,
                render: function (data, type, row) {
                    var status = row[4];
                    html =  '<div class="form-horizontal form-group">' +
                            '<div class="col-xs-3" style="margin-right: 12px"><button id="lookrow"  style="width: 60px" class="btn btn-success " >查看</button></div>' +
                            '<div class="col-xs-3" style="margin-right: 12px"><button id="editrow" style="width: 60px"  class="btn btn-primary  " >修改</button></div>' +
                             '<div class="col-xs-3" style="margin-right: 12px"><button id="delrow" style="width: 60px" class="btn btn-danger" >删除</button></div></div>';
                    return html;
                }
            }],
        "fnRowCallback":function(nRow,aData,iDisplayIndex){
            $('td:eq(0)', nRow).html('<a href="'+ base_url +'/server/zabbix/' + aData[0] + '">' +
                aData[0] + '</a>');
            return nRow;
        },
            "language":{
                "sProcessing":   "处理中...",
                "lengthMenu": "每页_MENU_ 条记录",
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
    $("#add-new").click(function(){
        $("#addhtml").modal("show");
    });
    $('#server tbody').on( 'click', 'button#lookrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#detail").modal("show");
        $('#detail_ip').html(data[0]);
        $('#detail_addres').html(data[1]);
        $('#detail_type').html(data[2]);
        $('#detail_os').html(data[3]);
        $('#detail_cpu').html(data[4]);
        $('#detail_mem').html(data[5]);
        $('#detail_disk').html(data[6]);
        $('#detail_department').html(data[7]);
        $('#detail_yw').html(data[8]);
        $('#detail_hostid').html(data[10]);
        $('#detail_bz').html(data[9]);
    });
    $('#server tbody').on( 'click', 'button#editrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#edithtml").modal("show");
        $('#etitle').html(data[0]);
        $('#eip').val(data[0]);
        $('#eaddress').val(data[1]);
        $('#etype').val(data[2]);
        $('#eos').val(data[3]);
        $('#ecpu').val(data[4]);
        $('#emem').val(data[5]);
        $('#edisk').val(data[6]);
        $('#edepartment').val(data[7]);
        $('#eyw option').each(function(){
            if($(this).text() == data[8]){
                $(this).attr("selected",true);
            };
        });
        $('#eid').val(data[11]);
        $('#ebz').val(data[9]);

    });
    $('#server tbody').on( 'click', 'button#delrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#deletehtml").modal("show");
        $('#did').val(data[11]);
    });
    $(".uread").attr('readonly','readonly');
    var base_url = $(location).attr('href').split("/").splice(0, 5).join("/");
    $('#addserver-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "/server/create",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#addserver-content').fadeOut('slow', function(){
                    $('#addserver-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('服务器增加失败');
            });
    });
    $('#editserver-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url + "/server/update",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#editserver-content').fadeOut('slow', function(){
                    $('#editserver-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('服务器增加失败');
            });
    });



})