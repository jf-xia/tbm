/**
 * Created by peng.wu2 on 2016/11/3
 */

$(document).ready(function(){
    $("#add1").click(function(){
        $("#addhtml").modal("show");
        $("#sname").val("机房");
    });
    $("#add2").click(function(){
        $("#addhtml").modal("show");
        $("#sname").val("机器类型");
    });
    $("#add3").click(function(){
        $("#addhtml").modal("show");
        $("#sname").val("操作系统");
    });

    $('.aupdate').click(function () {
        $("#edithtml").modal("show");
        var aoption = $(this).parents("tr").children("td:nth-child(1)").text();
        var avalue = $(this).parents("tr").children("td:nth-child(2)").text();
        var aorder = $(this).parents("tr").children("td:nth-child(3)").text();
        var astatus = $(this).parents("tr").children("td:nth-child(4)").text();
        var ades = $(this).parents("tr").children("td:nth-child(5)").text();
        $("#eoption").val(aoption);
        $("#evalue").val(avalue);
        $("#eorder").val(aorder);
        $("#estatus").val(astatus);
        $("#edes").val(ades);
    });
    $('.tupdate').click(function () {
        $("#edithtml").modal("show");
        var toption = $(this).parents("tr").children("td:nth-child(1)").text();
        var tvalue = $(this).parents("tr").children("td:nth-child(2)").text();
        var torder = $(this).parents("tr").children("td:nth-child(3)").text();
        var tstatus = $(this).parents("tr").children("td:nth-child(4)").text();
        var tdes = $(this).parents("tr").children("td:nth-child(5)").text();
        $("#eoption").val(toption);
        $("#evalue").val(tvalue);
        $("#eorder").val(torder);
        $("#estatus").val(tstatus);
        $("#edes").val(tdes);
    });
    $('.oupdate').click(function () {
        $("#edithtml").modal("show");
        var ooption = $(this).parents("tr").children("td:nth-child(1)").text();
        var ovalue = $(this).parents("tr").children("td:nth-child(2)").text();
        var oorder = $(this).parents("tr").children("td:nth-child(3)").text();
        var ostatus = $(this).parents("tr").children("td:nth-child(4)").text();
        var odes = $(this).parents("tr").children("td:nth-child(5)").text();
        $("#eoption").val(ooption);
        $("#evalue").val(ovalue);
        $("#eorder").val(oorder);
        $("#estatus").val(ostatus);
        $("#edes").val(odes);
    });

    $('.adelete').click(function () {
        $("#deletehtml").modal("show");
        var aoption = $(this).parents("tr").children("td:nth-child(1)").text();
        $("#doption").val(aoption);
    });
    $('.tdelete').click(function () {
        $("#deletehtml").modal("show");
        var toption = $(this).parents("tr").children("td:nth-child(1)").text();
        $("#doption").val(toption);
    });
    $('.odelete').click(function () {
        $("#deletehtml").modal("show");
        var ooption = $(this).parents("tr").children("td:nth-child(1)").text();
        $("#doption").val(ooption);
    });



})