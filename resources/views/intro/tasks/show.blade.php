<script type="text/javascript">
    function help(){
        $("form a").eq(0).attr({"href":"javascript:void(0);","data-step":"1","data-intro":"对当前任务内容进行修改。"});
        $("form button").attr({"href":"javascript:void(0);","data-step":"2","data-intro":"对当前任务内容进行删除。"});
        $(".box-primary").eq(0).attr({"href":"javascript:void(0);","data-step":"3","data-intro":"当前处理的任务详情。"});
        $(".box-primary").eq(1).attr({"href":"javascript:void(0);","data-step":"4","data-intro":"显示每个任务阶段的时间轴及处理详情"});
        introJs().start();
    }
</script>