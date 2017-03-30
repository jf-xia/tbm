{!! Form::open(['route' => ['taskgroups.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('tasks.show', $taskid) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('".trans('view.Are you sure to exit this task group? if you need to add this task group after you exit, contact the task owner')."')"
    ]) !!}
</div>
{!! Form::close() !!}
