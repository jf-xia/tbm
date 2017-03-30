
<script type="text/javascript">
    //
    function help(){
        $("#tasktype").attr({"data-step":"1","data-intro":"创建任务时，需点击下拉框选择任务类型。"});
        $("#new-event").attr({"data-step":"2","data-intro":"此文本输入任务标题；任务类型分为四种（以*开头表示未重要不紧急；！为重要紧急；^为不重要紧急；~为不重要不紧急。）可通过两种方式操作：1.手动输入标识符再输入标题内容" +
        "点击添加，会在下方的“备忘任务清单”中显示标题。2.也可通过点击文本下方四个不同颜色的按钮后，输入任务标题，点击添加。"});
        $("#color-chooser").attr({"data-step":"3","data-intro":"点击选择任务颜色标签, 根据四象限法则分为重要不紧急/重要紧急/不重要紧急/不重要不紧急"});
        $("#external-events").attr({"data-step":"4","data-intro":"此处为待计划任务清单，添加任务后，此处会生成一个任务标签。点击鼠标左键按住当前任务标签按钮，拖动至对应日期及处理时间段，松开鼠标左键即可。拖动完成后可以点击该事件，修改时间；或直接选中事件选项下边框，直接拖动，改变时间段。若该任务标签生成错误，可点击鼠标左键，会出现 “查看、编辑、删除”按钮进行操作。"});
        $("#delete-remove").attr({"data-step":"5","data-intro":"勾选时,在日历中删除的任务会回到备忘任务清单;不勾选则直接删除任务"});
        $('.fc-head').attr({"data-step":"6","data-intro":"可在日历中拖动修改任务时间, 当鼠标悬停在任务上时,可使用快捷按钮，包括：查看、修改、复制任务、删除、更新状态（完成或暂停）、分享(或取消分享)"});

        introJs().start();
//            introJs().setOptions({ 'nextLabel': 'next', 'prevLabel': 'prevLabel', 'skipLabel': 'skipLabel', 'doneLabel': 'doneLabel' }).start();
    }
</script>