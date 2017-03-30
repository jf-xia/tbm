{!! Form::open(['route' => ['projects.destroy', $project_id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('projects.show', $project_id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    {{--<a href="{{ route('projects.edit', $project_id) }}" class='btn btn-default btn-xs'>--}}
        {{--<i class="glyphicon glyphicon-edit"></i>--}}
    {{--</a>--}}
    {{--{!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [--}}
        {{--'type' => 'submit',--}}
        {{--'class' => 'btn btn-danger btn-xs',--}}
        {{--'onclick' => "return confirm('Are you sure?')"--}}
    {{--]) !!}--}}
</div>
{!! Form::close() !!}
