
<script type="text/javascript">
    //
    function help(){
        $(".buttons-page-length span").attr({"data-step":"2","data-intro":"当前页默认显示10条记录，可点击下拉框进行选择。"});
        $(".buttons-print span").attr({"data-step":"3","data-intro":"打印当前页面"});
        $(".buttons-reset span").attr({"data-step":"4","data-intro":"重置页面"});
        $(".buttons-reload span").attr({"data-step":"5","data-intro":"刷新页面"});
        $(".buttons-excel span").attr({"data-step":"6","data-intro":"点击，将当前页面导出至excel"});
        $(".buttons-colvis span").attr({"data-step":"7","data-intro":"点击此按钮，将不需要显示的字段删除，根据自己的需求将我的任务表自定义列进行显示。"});

        $("#dataTableBuilder_filter label").attr({"data-step":"8","data-intro":"在搜索框内，输入您想筛选的内容后，会自动筛选出来相关内容。"});
        $(".dataTables_scroll").attr({"data-step":"9","data-intro":"此区域为任务列表显示内容区域。"});
        $("#dataTableBuilder_paginate").attr({"data-step":"10","data-intro":"页数显示。可根据需求点击任意页面信息，相应页面内容也会显示出来~"});
        $(".navbar-custom-menu ul li").eq(1).attr({"data-step":"11","data-intro":"您的提醒"});
        $(".tasks-menu").attr({"data-step":"12","data-intro":"您待办的任务"});
        introJs().start();
//            introJs().setOptions({ 'nextLabel': 'next', 'prevLabel': 'prevLabel', 'skipLabel': 'skipLabel', 'doneLabel': 'doneLabel' }).start();
    }
</script>