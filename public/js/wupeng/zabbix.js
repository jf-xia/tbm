/**
 * Created by peng.wu2 on 2016/10/27.
 */

$(document).ready(function(){
    var base_url = $(location).attr('href').split("/").splice(0, 5).join("/");
    $('#zabbix').DataTable({
        "columnDefs": [
            { "width": "15%", "targets": 0},
            { "width": "10%", "targets": 1 },
            { "width": "10%", "targets": 2 },
            { "width": "10%", "targets": 3 },
            { "width": "15%", "targets": 4 },
            { "width": "15%", "targets": 5 },
            { "width": "25%", "targets": 6 }
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
    });


})