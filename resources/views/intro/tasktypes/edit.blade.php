<script type="text/javascript">
    function help(){
        $(".sidebar-menu li").eq(5).attr({"data-step":"1","data-intro":"根据实际需求，自定义一个个字段，构成一个任务类型"});
        $("form div").eq(0).attr({"data-step":"2","data-intro":"填写您所创建的任务名称。（可以自定义命名）"});
        $("form div").eq(1).attr({"data-step":"3","data-intro":"选择是否关联产品，若选择“Yes”,那么在该任务表中会自动生成关联产品字段；若需要新增产品，可点击左侧导航栏中的“产品管理”进行新建产品。"});
        $("form div").eq(2).attr({"data-step":"4","data-intro":"选择是否关联项目，若选择“Yes”,那么在该任务表中会自动生成关联项目字段；若需要新增项目，可点击左侧导航栏中的“项目列表”进行新建项目。"});
        $("form div").eq(3).attr({"data-step":"5","data-intro":"多次分配是指该任务可以同时分配给多人。"});
        $("form div").eq(5).attr({"data-step":"6","data-intro":"选择“任务类型”是指当前任务将会流转到下一个任务的名称。"});
        $("form div").eq(6).attr({"data-step":"7","data-intro":"任务请求/分配是指将当前任务分配到下一任务处理人，可点击“文本框”直接搜索输入处理人的姓名即可。"});
        $(".content div").eq(0).attr({"data-step":"8","data-intro":"此处为该任务表中字段，可点击“新建按钮”新增字段，或点击“编辑”或“删除”按钮对字段进行修改或删除。"});
        introJs().start();
    }
</script>