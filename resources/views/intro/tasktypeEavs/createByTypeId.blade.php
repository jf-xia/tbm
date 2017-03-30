<script type="text/javascript">
    function help(){

        $("form div").eq(0).attr({"data-step":"1","data-intro":"填写您所创建的属性名称。（可以自定义命名）"});
        $("form div").eq(1).attr({"data-step":"2","data-intro":"输入类型可根据所填写的内容进行选择，如：若该字段是日期型，可在下拉框中选择“日期输入框”"});
        $("form div").eq(2).attr({"data-step":"3","data-intro":"是否为必填项，若为必填项选择“Yes”若非必填项选择“No”"});
        $("form div").eq(3).attr({"data-step":"4","data-intro":"判断该字段是否仅有一个，具有唯一性；若该字段具有唯一性可选择“Yes”，否则选择“No”"});
        $("form div").eq(4).attr({"data-step":"5","data-intro":"该字段输入框所占一行宽度的百分比如：50%、100%；可根据页面排版与实际需求进行设置输入框的宽度。"});
        $("form div").eq(5).attr({"data-step":"6","data-intro":"字段顺序排列"});
        $("form div").eq(6).attr({"data-step":"7","data-intro":"此选项根据“输入类型”进行填写。当“输入类型”选择“单选下拉框”,“选项框属性组”填写对应的各个选项内容；（在“选项框属性组”输入框中输入选项内容后，在下拉框中选中即可）。"});
        $("form div").eq(7).attr({"data-step":"8","data-intro":"对于此属性进行备注说明。"});
        introJs().start();
    }
</script>
