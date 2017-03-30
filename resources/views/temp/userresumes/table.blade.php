<table class="table table-responsive" id="userresumes-table">
    <thead>
        @lang('view.Action')
        <th>@lang('view.Keyname')</th>
        <th>@lang('view.Content')</th>
        <th>@lang('view.User Id')</th>
        <th colspan="3">Action</th>
    </thead>
    <tbody>
    @foreach($userresumes as $userresume)
        <tr>
           @lang('<td>{!! $userresume->trkeyname !!}</td>
            <td>{!! $userresume->trcontent !!}</td>
            <td>{!! $userresume->truser_id !!}</td>')
            <td>
                {!! Form::open(['route' => ['userresumes.destroy', $userresume->id], 'method' => 'delete']) !!}
                <div class='btn-group'>
                    <a href="{!! route('userresumes.show', [$userresume->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                    <a href="{!! route('userresumes.edit', [$userresume->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                </div>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>