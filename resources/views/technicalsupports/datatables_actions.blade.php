{!! Form::open(['route' => ['technicalsupports.destroy', $q_id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('technicalsupports.show', $q_id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    <a href="{{ route('technicalsupports.edit', $q_id) }}" title="@lang('view.Edit')" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('Are you sure?')"
    ]) !!}
</div>
{!! Form::close() !!}
