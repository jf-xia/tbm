
$(document).ready(function() {

    {{--$('#%1$s tfoot th').each( function () {--}}
        {{--var title = $(this).text();--}}
        {{--$(this).html( '<input class="dbsearch" type="text" class="s'+title+'" placeholder="'+title+' Search" />' );--}}
    {{--} );--}}

    var table = $("#%1$s").DataTable(%2$s);

    {{--// Apply the search--}}
    {{--table.columns().every( function () {--}}
        {{--var that = this;--}}

        {{--$( 'input', this.footer() ).on( 'keyup change', function () {--}}
            {{--if ( that.search() !== this.value ) {--}}
                {{--that--}}
                {{--.search( this.value )--}}
                {{--.draw();--}}
            {{--}--}}
        {{--} );--}}
    {{--} );--}}
