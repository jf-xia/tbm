/**
 * Created by peng.wu2 on 2016/11/3
 */

$(document).ready(function(){
    $("#add").click(function(){
        $("#addhtml").modal("show");
        $("#sname").val("机房");
    });

    $('.update').click(function () {
        $("#edithtml").modal("show");
        var eid = $(this).parents("tr").children("td:nth-child(1)").text();
        var ename = $(this).parents("tr").children("td:nth-child(2)").text();
        var evalue = $(this).parents("tr").children("td:nth-child(3)").text();
        var eorder = $(this).parents("tr").children("td:nth-child(4)").text();
        var estatus = $(this).parents("tr").children("td:nth-child(5)").text();
        $("#eid").val(eid);
        $("#ename").val(ename);
        $("#evalue").val(evalue);
        $("#eorder").val(eorder);
        $("#estatus").val(estatus);
    });


    $('.delete').click(function () {
        $("#deletehtml").modal("show");
        var did = $(this).parents("tr").children("td:nth-child(1)").text();
        $("#did").val(did);
    });





})