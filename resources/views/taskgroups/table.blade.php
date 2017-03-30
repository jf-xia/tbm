@section('css')
    @include('layouts.datatables_css')
@endsection

<div class="form-group col-sm-2">
    {!! Form::select('taskstatus_select',[5=>trans('view.All Task')
                                                ,1=>trans('view.Sub Task')
                                                ,0=>trans('view.Main Task')
                                                ,2=>trans('view.Uncommented Task')
                                                ,3=>trans('view.Good Task')
                                                ,4=>trans('view.Bad Task')
                                                ],substr(Request::getRequestUri(),-1),
        ['class' => 'form-control','onchange'=>"window.location.href='".url('taskgroups/type')."/'+$(this).children('option:selected').val();"]) !!}
</div>

<div class="form-group col-sm-2">
    <?php $selectTaskStatus = (array_column(\App\Models\Taskstatus::all('name','id')->toArray(),'name','name'));
    $selectTaskStatus[null] = '全部任务状态'; ?>
    {!! Form::select('taskstatus_select',$selectTaskStatus,null, ['class' => 'form-control','id'=>'taskstatus_select']) !!}
</div>
<div class="form-group col-sm-2">
    <?php
    $selectTaskType = (array_column(\App\Models\Tasktype::all('name','id')->toArray(),'name','name'));
    $selectTaskType[null] = '全部任务类型';
    ?>
    {!! Form::select('tasktype_select',$selectTaskType,null, ['class' => 'form-control','id'=>'tasktype_select']) !!}
</div>
<div class="form-group col-sm-2">
    <?php
    $selectTeam = \Auth::user()->getTeams(\Auth::id(),[\Auth::id()=>\Auth::user()->name]);
    $selectTeam = array_combine(array_values($selectTeam), $selectTeam);
    $selectTeam[null] = '全部成员';
    ?>
    {!! Form::select('team_select',$selectTeam,null, ['class' => 'form-control','id'=>'team_select']) !!}
</div>

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    <?php
    $addon = "
    $('#taskstatus_select').on( 'change', function () { table.columns(5).search( this.value ).draw();} );
    $('#tasktype_select').on( 'change', function () { table.columns(6).search( this.value ).draw();} );
    $('#team_select').on( 'change', function () { table.columns(7).search( this.value ).draw();} );
    $('#dataTableBuilder tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var rid = (tr.find('td:first-child').text());
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            var eavData = $.ajax({url:'".url('')."/tasks/showajax/'+rid,async:false}).responseText;
            row.child( eavData ).show();
            tr.addClass('shown');
        }
    } );" ?>
    {!! $dataTable->scripts(null,$addon) !!}

    <script type="text/javascript">
        function comment(tgid,tgval){
            var comvalue = $('#comment'+tgid).val();
            if (comvalue=='') { comvalue=tgval; }
            var comment = $.ajax({url:'{{ url('') }}/taskgroups/updateajax/'+tgid+'/'+tgval+'/'+comvalue,async:false}).responseText;
            alert(comment);
            $('#comment'+tgid).closest('tr').hide();
            //$('#comment'+tgid).attr('readonly','readonly');
        }
    </script>
@endsection