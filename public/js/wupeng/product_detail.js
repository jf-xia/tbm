/**
 * Created by peng.wu2 on 2016/11/7.
 */
$(document).ready(function(){
    $(".tdis").css("display",'none')
    $(".prd-rd").attr('readonly','readonly');
    $("#pro_title").css('margin-bottom','20px');

    //edit product
    $("#emain").click(function(){
        $("#editproduct").modal("show");
        var prod_group = $("#prod_group").val();
        var prod_department = $("#prod_departmnet").val();
        var yunwei = $("#prod_yunwei").val();
        var prod_status = $("#prod_status").val();
        var prod_enable = $("#prod_enable").val();
        var prod_mode =$("#prod_mode").val();
        var prod_arch =$("#prod_arch").val();
        var database_type =$('#database_type').val();
        var lstart =$('#lstart').val();
        var lend =$('#lend').val();
        $("#eprod_group option:contains(" +prod_group+ ")").attr("selected",true);
        $("#eprod_departmnet option:contains(" +prod_department+ ")").attr("selected",true);
        $("#eyunwei option:contains(" +yunwei+ ")").attr("selected",true);
        $("#eprod_arch option:contains(" +prod_arch+ ")").attr("selected",true);
        $("#eprod_enable option").each(function(){
            if($(this).text() == prod_enable ){
                $(this).attr("selected",true);
            }
        });
        $("#eprod_mode option:contains(" +prod_mode+ ")").attr("selected",true);
        $("#eprod_arch option:contains(" +prod_arch+ ")").attr("selected",true);
        $("#estatus option:contains(" +prod_status+ ")").attr("selected",true);
        $("#edatabase_type").val(database_type);
        $("#elstart").val(lstart);
        $("#elend").val(lend);

    });
    //delete product
    $("#dmain").click(function(){
        $("#proddelete").modal("show");
    });

    //web
    $("#add_web").click(function(){
        $("#addweb").modal("show");
    });
    $(".web_show").click(function(){
        $("#webshow").modal("show");
        var senv = $(this).parents("#webtable tr").children('td:nth-child(1)').text();
        var sns_in = $(this).parents("#webtable tr").children('td:nth-child(2)').text();
        var ssk_out = $(this).parents("#webtable tr").children('td:nth-child(3)').text();
        var s_admin = $(this).parents("#webtable tr").children('td:nth-child(4)').text();
        var s_ns_out = $(this).parents("#webtable tr").children('td:nth-child(5)').text();
        var ssk_in = $(this).parents("#webtable tr").children('td:nth-child(6)').text();
        var s_user = $(this).parents("#webtable tr").children('td:nth-child(7)').text();
        var s_des = $(this).parents("#webtable tr").children('td:nth-child(9)').text();
        var s_domain = $(this).parents("#webtable tr").children('td:nth-child(8)').text();
        $("#show_web_env").html(senv);
        $("#show_web_nsin").html(sns_in);
        $("#show_web_nsout").html(s_ns_out);
        $("#show_web_skin").html(ssk_in);
        $("#show_web_skout").html(ssk_out);
        $("#show_web_user").html(s_user);
        $("#show_web_admin").html(s_admin);
        $("#show_web_des").html(s_des);
        $("#show_web_domain").html(s_domain);
    });
    $(".web_edit").click(function(){
        $("#webedit").modal("show");
        var senv = $(this).parents("#webtable tr").children('td:nth-child(1)').text();
        var sns_in = $(this).parents("#webtable tr").children('td:nth-child(2)').text();
        var ssk_out = $(this).parents("#webtable tr").children('td:nth-child(3)').text();
        var s_admin = $(this).parents("#webtable tr").children('td:nth-child(4)').text();
        var s_ns_out = $(this).parents("#webtable tr").children('td:nth-child(5)').text();
        var ssk_in = $(this).parents("#webtable tr").children('td:nth-child(6)').text();
        var s_user = $(this).parents("#webtable tr").children('td:nth-child(7)').text();
        var s_des = $(this).parents("#webtable tr").children('td:nth-child(9)').text();
        var s_domain = $(this).parents("#webtable tr").children('td:nth-child(8)').text();
        var sid = $(this).parents("#webtable tr").children('td:nth-child(10)').text();
        $("#eweb_env option").each(function(){
            if($(this).text() == senv ){
                $(this).attr("selected",true);
            };
        });
        $("#eweb_id").val(sid);
        $("#ens_inner").val(sns_in);
        $("#ens_outer").val(s_ns_out);
        $("#esk_inner").val(ssk_in);
        $("#esk_outer").val(ssk_out);
        $("#euser_account").val(s_user);
        $("#eadmin_account").val(s_admin);
        $("#edescript").val(s_des);
        $("#edomain_name").val(s_domain);
    });

    $(".web_delete").click(function(){
        $("#webdelete").modal("show");
        var sid = $(this).parents("#webtable tr").children('td:nth-child(10)').text();
        $("#web_did").val(sid);
    });

    //app
    $("#add_app").click(function(){
        $("#addapp").modal("show");
    });
    $(".app_show").click(function(){
        $("#appshow").modal("show");
        var show_app_env = $(this).parents('tr').children("td:nth-child(1)").text();
        var show_app_prod_type = $(this).parents('tr').children("td:nth-child(2)").text();
        var show_app_prod_web_ip = $(this).parents('tr').children("td:nth-child(3)").text();
        var show_app_web_port = $(this).parents('tr').children("td:nth-child(4)").text();
        var show_app_prod_desc = $(this).parents('tr').children("td:nth-child(5)").text();
        $("#show_app_env").html(show_app_env);
        $("#show_app_prod_type").html(show_app_prod_type);
        $("#show_app_prod_web_ip").html(show_app_prod_web_ip);
        $("#show_app_web_port").html(show_app_web_port);
        $("#show_app_prod_desc").html(show_app_prod_desc);
    });
    $(".app_edit").click(function(){
        $("#appedit").modal("show");
        var eapp_env = $(this).parents('tr').children("td:nth-child(1)").text();
        var eapp_prod_type = $(this).parents('tr').children("td:nth-child(2)").text();
        var eapp_prod_web_ip = $(this).parents('tr').children("td:nth-child(3)").text();
        var eapp_web_port = $(this).parents('tr').children("td:nth-child(4)").text();
        var eapp_prod_desc = $(this).parents('tr').children("td:nth-child(5)").text();
        var eid = $(this).parents("tr").children('td:nth-child(6)').text();
        $("#eapp_env option").each(function(){
            if($(this).text() == eapp_env){
                $(this).attr("selected",true);
            };
        });
        $("#eapp_prod_type option:contains("+eapp_prod_type +")").attr("selected",true);
        $("#eapp_prod_web_ip").val(eapp_prod_web_ip);
        $("#eapp_web_port").val(eapp_web_port);
        $("#eapp_prod_desc").val(eapp_prod_desc);
        $("#app_eid").val(eid)
    });

    $(".app_delete").click(function(){
        $("#appdelete").modal("show");
        var did = $(this).parents("tr").children('td:nth-child(6)').text();
        $("#app_did").val(did);
    });



    //DB
    $("#add_db").click(function () {
        $("#dbadd").modal("show");
    });
    $(".showdb").click(function(){
        $("#dbdetail").modal("show");
        //var id = $(this).parents("#dbtable tr").children("td:nth-child(1)").text();
        var dbenv = $(this).parents("#dbtable tr").children("td:nth-child(2)").text();
        var dbtype = $(this).parents("#dbtable tr").children("td:nth-child(3)").text();
        var dbip = $(this).parents("#dbtable tr").children("td:nth-child(4)").text();
        var dbname = $(this).parents("#dbtable tr").children("td:nth-child(5)").text();
        var dbdes = $(this).parents("#dbtable tr").children("td:nth-child(6)").text();
        var dbuser = $(this).parents("#dbtable tr").children("td:nth-child(7)").text();
        var dbpass = $(this).parents("#dbtable tr").children("td:nth-child(8)").text();
        var dbport = $(this).parents("#dbtable tr").children("td:nth-child(9)").text();
        $("#showenv").html(dbenv)
        $("#showtype").html(dbtype)
        $("#showip").html(dbip)
        $("#showname").html(dbname)
        $("#showdes").html(dbdes)
        $("#showuser").html(dbuser)
        $("#showpass").html(dbpass)
        $("#showport").html(dbport)
    });
    $(".editdb").click(function(){
        $("#dbedit").modal("show");
        var id = $(this).parents("#dbtable tr").children("td:nth-child(1)").text();
        var dbenv = $(this).parents("#dbtable tr").children("td:nth-child(2)").text();
        var dbtype = $(this).parents("#dbtable tr").children("td:nth-child(3)").text();
        var dbip = $(this).parents("#dbtable tr").children("td:nth-child(4)").text();
        var dbname = $(this).parents("#dbtable tr").children("td:nth-child(5)").text();
        var dbdes = $(this).parents("#dbtable tr").children("td:nth-child(6)").text();
        var dbuser = $(this).parents("#dbtable tr").children("td:nth-child(7)").text();
        var dbpass = $(this).parents("#dbtable tr").children("td:nth-child(8)").text();
        var dbport = $(this).parents("#dbtable tr").children("td:nth-child(9)").text();
        $("#edbid").val(id)
        $("#edbenv option").each(function(){
            if($(this).text() == dbenv){
                $(this).attr("selected",true);
            };
        });
        $("#edbtype option").each(function(){
            if($(this).text() == dbtype){
                $(this).attr("selected",true);
            };
        });
        $("#edbip").val(dbip)
        $("#edbname").val(dbname)
        $("#edbdes").val(dbdes)
        $("#edbuser").val(dbuser)
        $("#edbpass").val(dbpass)
        $("#edbport").val(dbport)
    });
    $(".deletedb").click(function(){
        $("#dbdelete").modal("show");
        var id = $(this).parents("#dbtable tr").children("td:nth-child(1)").text();
        $("#db_did").val(id)
    });


})