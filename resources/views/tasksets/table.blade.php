@section('css')
    @include('layouts.datatables_css')
@endsection
<input type="hidden" value="" id="selected_row" />

<div class="bg-info hidden assign_to">
    {!! Form::open(['route' => 'tasks.store','class'=>'form-inline']) !!}
    {!! Form::hidden('taskstatus_id', 1) !!}
    <?php
    //todo 抽象task保存方法
    $assigned_to = $tasktype->assigned_to;
    ?>
    <div class="callout callout-info col-sm-12">
        <div class="col-sm-3">
            @lang('view.Ask')<br />
            {!! Form::select('assigned_to',[$assigned_to=>$assigned_to?$tasktype->assignedto->name:null], null, ['class' => 'form-control select2-ajax-users','required'=>'required','style'=>'width: 100%;']) !!}
        </div>
        <div class="col-sm-3">
            @lang('view.Handling/Assistance')<br />
            {!! Form::select('tasktype_id',$tasktype->tasktype_select, null, ['class' => 'form-control','required'=>'required','placeholder'=>trans('view.Select task type'),'style'=>'width: 100%;']) !!}
        </div>
        <div class="col-sm-6">
            @lang('view.Task Title:')<br />
            <div class="form-group">
                {!! Form::text('title', null, ['class' => 'form-control','required'=>'required']) !!}
                {!! Form::submit(trans('view.Submit'), ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>

{!! $dataTable->table(['width' => '100%']) !!}
@section('scripts')
    @include('layouts.datatables_js')
    <?php
    $addons="
    $('#dataTableBuilder tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
        $('#selected_row').val(table.rows('.selected').data().toArray().map(function(x) { return x['id']; }));
    });";
    ?>
    {!! $dataTable->scripts(null,$addons) !!}

    <script type="text/javascript">
        select2(".select2-ajax-users","/tasks/usersajaxlist")
    </script>
@endsection