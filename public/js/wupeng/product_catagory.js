/**
 * Created by peng.wu2 on 2016/11/3
 */

$(document).ready(function(){
    $("#add").click(function(){
        $("#addhtml").modal("show");
    });

    $('.update').click(function () {
        $("#edithtml").modal("show");
        var eid = $(this).parents("tr").children("td:nth-child(1)").text();
        var ename = $(this).parents("tr").children("td:nth-child(2)").text();
        var edes = $(this).parents("tr").children("td:nth-child(3)").text();
        $("#eid").val(eid);
        $("#ename").val(ename);
        $("#edes").val(edes);
    });

    $('.delete').click(function () {
        $("#deletehtml").modal("show");
        var did = $(this).parents("tr").children("td:nth-child(1)").text();
        var dname = $(this).parents("tr").children("td:nth-child(2)").text();
        $("#eid").val(eid);
        $("#ename").val(ename);
    });





})