{{--新增弹框--}}
<div class="modal fade" id="addapp" tabindex="-1" role="dialog" aria-labelledby="addappLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="addappLabel">新增业务库管理类型</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group" id="addapp-content">
                        <form  id="addapp-form" method="post" >
                            <label>名称：</label>
                            <input class="form-control" type="text" name="name" id="name" required>
                            <label>描述：</label><textarea class="form-control" type="text" name="context" id="context" ></textarea>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button  class="btn btn-primary">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{--修改弹框--}}
<div class="modal fade" id="updateapp" tabindex="-1" role="dialog" aria-labelledby="updateappLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="addappLabel">修改业务库管理类型</h4>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <div class="form-group" id="addapp-content">
                        <form  id="addapp-form" method="post" >
                            <label>名称：</label>
                            <input class="form-control" type="text" name="name" id="name" value="" required>
                            <label>描述：</label><textarea class="form-control" type="text" name="context" id="context"  >ddd</textarea>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                <button  class="btn btn-primary">保存</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
{{--删除--}}
<div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="deleteappLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">

         <form id="deleform" method="post" action="{{ url('bentitype/s') }}">
            <div class="modal-body">
                 <div class="box-body">
                      <div id="delete_name">是否确认删除？</div>
                 </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-danger" >删除</button>
            </div>
         </form>
      </div>
  </div>
</div>