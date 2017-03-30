/**
 * Created by peng.wu2 on 2016/10/27.
 */

$(document).ready(function(){
    var base_url = $(location).attr('href').split("/").splice(0, 5).join("/")+"/department";
    $("table th:eq(0)").css('width','12%');
    $("table th:eq(1)").css('width','15%');
    $("table th:eq(2)").css('width','25%');
    $("table th:eq(3)").css('width','15%');
    $("table th:eq(4)").css('width','7%');
    $("table th:eq(5)").css('text-align','center');
    $(".lopk-title").css("width","20%");

    var tables = $('#department').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "ajax":{
                url :base_url+"/_list",
            },
            aColumns:[
                {data: "groups"},
                {data: "dept_descrip"},
                {data: "department"},
                {data: "modify_date"},
                {data: "dept_status"},
            ],
        //"fnRowCallback":function(nRow,aData,iDisplayIndex){
        //    $('td:eq(0)', nRow).html('<a href="'+ window.location.pathname +'/detail/' + aData[5] + '">' +
        //        aData[0] + '</a>');
        //    return nRow;
        //},
            aoColumnDefs:[{
                targets: 5,
                render: function (data, type, row) {
                    var status = row[4];
                    html =  '<div class="form-horizontal form-group">' +
                        '<div class="col-xs-3"><button  id="addrow" style="width: 60px" class="btn btn-primary"  >新增</button></div>' +
                        '<div class="col-xs-3"><button id="lookrow"  style="width: 60px" class="btn btn-success "   >查看</button></div>';

                    if (status == "已发布"){
                        html += '<div class="col-xs-3"><button id="editrow"  style="width: 60px" class="btn btn-info "   >修改</button></div>';
                        html +=  '<div class="col-xs-3"><button id="downrow"  style="width: 60px" class="btn btn-warning "  >下架</button></div></div>';
                    }else{
                        html += '<div class="col-xs-3"><button id="uprow"  style="width: 60px" class="btn btn-warning "   >上架</button></div>';
                        html +=  '<div class="col-xs-3"><button id="delrow"  style="width: 60px" class="btn btn-danger "  >删除</button></div></div>';
                    }
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
    $('#department tbody').on( 'click', 'button#addrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        //alert(data[0]);
        $("#addhtml").modal("show");
        $('#dep-name').val(data[0]);
        $('#dept_pid').val(data[5]);
    });
    $('#department tbody').on( 'click', 'button#lookrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#lookhtml").modal("show");
        $('#look-title').html(data[0]);
        $('#look-group').html(data[0]);
        $('#look-des').html(data[1]);
        $('#look-department').html(data[2]);
        $('#look-date').html(data[3]);
        $('#look-status').html(data[4]);
    });
    $('#department tbody').on( 'click', 'button#editrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#edithtml").modal("show");
        $('#edit-title').html(data[0]);
        $('#groupName').val(data[0]);
        $('#groupDes').val(data[1]);
        $('#groupStaus').val(data[4]);
        $('#groupId').val(data[5]);
    });
    $("#add-new").click(function(){
        $("#addgrouphtml").modal("show");
    });
    $('#department tbody').on( 'click', 'button#downrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#downgrouphtml").modal("show");
        $('#down_name').append(data[0]);
        $('#down_id').val(data[5]);
    });
    $('#department tbody').on( 'click', 'button#uprow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#upgrouphtml").modal("show");
        $('#up_name').append(data[0]);
        $('#up_id').val(data[5]);
    });
    $('#department tbody').on( 'click', 'button#delrow', function () {
        var data = tables.row( $(this).parents('tr') ).data();
        $("#deletehtml").modal("show");
        $('#delete_name').append(data[0]);
        $('#delete_id').val(data[5]);
    });
    $('#addgroup-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url+"/createGroup",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#group_content').fadeOut('slow', function(){
                    $('#group_content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('提交失败');
            });
    });
    $('#add-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url+"/createDepartment",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#department-content').fadeOut('slow', function(){
                    $('#department-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('提交失败');
            });
    });
    $('#edit-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url+"/update",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#editgroup-content').fadeOut('slow', function(){
                    $('#editgroup-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改失败');
            });
    });

})