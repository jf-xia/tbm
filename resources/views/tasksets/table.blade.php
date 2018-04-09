@section('css')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%']) !!}
<input type="hidden" value="" id="selected_row" />
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
@endsection