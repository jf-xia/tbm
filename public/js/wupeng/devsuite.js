/**
 * Created by peng.wu2 on 2016/11/02/.
 */

$(document).ready(function(){
    $("#type").css('width','17%');
    $("#ptype").css('width','10%');
    $("#pname").css('width','16%');
    $("#name").css('width','15%');
    $("#pmanager").css('width','10%');
    $("#manager").css('width','10%');
    var table = $('#devsuite').DataTable({
            "aProcessing": true,
            "aServerSide": true,
            "ajax":{
                url :window.location.pathname+"/_list",
            },
            aaSorting: [[ 4, "desc" ]],
            "fnRowCallback":function(nRow,aData,iDisplayIndex){
                $('td:eq(0)', nRow).html('<a href="'+ window.location.pathname +'/detail/' + aData[8] + '">' +
                    aData[0] + '</a>');
                return nRow;
            },
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
    } );

    //底部筛选
    //$('#devsuite tfoot th').each( function () {
    //    var title = $(this).text();
    //    $(this).html( '<input class="tfoots" type="text" placeholder="筛选 '+title+'" />' );
    //} );
    //table.columns().every( function () {
    //    var that = this;
    //    $( 'input', this.footer() ).on( 'keyup change', function () {
    //        if ( that.search() !== this.value ) {
    //            that
    //                .search( this.value )
    //                .draw();
    //        }
    //    } );
    //});

    $(".tfoots").css('width','100px');
    $("#dev_title").css('margin-bottom','20px')
    $("#pro_title").css('margin-bottom','20px')
    $(".oam-read").attr('readonly','readonly');

})