/**
 * Created by peng.wu2 on 2016/11/7.
 */
$(document).ready(function(){
    var base_url = $(location).attr('href').split("/").splice(0, 5).join("/")+"/product";
    $('#product').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        ajax: base_url + '/_list',
        "columnDefs": [
            { "width": "30px", "targets": 0},
            { "width": "30px", "targets": 2 },
            { "width": "30px", "targets": 3 },
            { "width": "30px", "targets": 4 },
            { "width": "60px", "targets": 5 },
            { "width": "60px", "targets": 6 },
            { "width": "60px", "targets": 7 },
            { "width": "50px", "targets": 8 },
            { "width": "50px", "targets": 9 },
            { "width": "12%", "targets": 10 },

        ],
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
        "fnRowCallback":function(nRow,aData,iDisplayIndex){
            $('td:eq(1)', nRow).html('<a href="'+base_url +'/product/detail/' + aData[0] + '">' +
                aData[1] + '</a>');
            return nRow;
        },
    });

    var dt =new Date();
    var dt_m = (dt.getMonth() + 1) .toString();
    var dt_d = dt.getDate().toString();
    var now =    dt_m + dt_d;
    var s = parseInt((Math.random() * 9000) + 1000);
    var product_code ="CP" + now +s;

    $("#addprod").click(function(){
        $("#addproduct").modal("show");
        $("input[name='prod_sku']").val(product_code);
    });

    $('#addproduct-form').submit(function(e){
        e.preventDefault();
        $.ajax({
                url :base_url+"/product/create",
                type: 'POST',
                data: $(this).serialize(),
            })
            .done(function(data){
                $('#addproduct-content').fadeOut('slow', function(){
                    $('#addproduct-content').fadeIn('slow').html(data);
                });
            })
            .fail(function(){
                alert('修改失败');
            });
    });
})