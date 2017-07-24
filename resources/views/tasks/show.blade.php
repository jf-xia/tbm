@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">
            @lang('view.Task')@lang('view.show') - {{ $task->tasktype_name }}
        </h1>
        <h1 class="pull-right">
            {!! Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
            @if(\Auth::id()==$task->user_id)
                @if($task->price)
                <a href="{!! route('index.post',$task->id) !!}" class="btn btn-warning">@lang('view.View Posts')</a>
                @endif
                <a href="{!! route('tasks.share',$task->id) !!}" class="btn btn-success"><i class="glyphicon glyphicon-heart{{ $task->price ? '':'-empty' }}" title="@lang('view.Share')" > </i></a>
                <a href="{!! route('tasks.edit',$task->id) !!}" class="btn btn-primary">@lang('view.edit')</a>
                {!! Form::button(trans('view.Delete'), [
                    'type' => 'submit',
                    'class' => 'btn btn-danger',
                    'onclick' => "return confirm('Are you sure?')"
                ]) !!}
            @endif
            <a href="{!! route('tasks.index') !!}" class="btn btn-default">@lang('view.Back')</a>
            {!! Form::close() !!}
        </h1>
        <div class="clearfix"></div>
    </section>
    <div class="content">
        @include('flash::message')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                @if(!$task->first_task)
                    <div class="callout callout-danger">
                        <h4>@lang('view.The initial task does not exist - the current task cannot be assigned to another person')</h4>
                    </div>
                @elseif(!$task->tasktype->tasktype_select)
                    <div class="callout callout-warning">
                        <h4>@lang('view.The closed task or closed loop task can not be distributed(can be modify configuration type by department management account)')</h4>
                    </div>
                @elseif($task->taskstatus_id<>5)
                    <div class="callout callout-info">
                        <h4>@lang('view.When the task state is completed, the current task can be submitted to the next step')</h4>
                    </div>
                @elseif(!$task->taskIsAssigned)
                    <div class="callout callout-success">
                        <h4>@lang('view.Task has assigned - current task cannot be assigned to others')</h4>
                    </div>
                @else
                    <div class="bg-info">
                    {!! Form::open(['route' => 'tasks.store','class'=>'form-inline']) !!}
                    {!! Form::hidden('task_id', $task->task_id?$task->task_id:$task->id) !!}
                    {!! Form::hidden('taskstatus_id', 1) !!}
                    {!! Form::hidden('product_id', $task->product_id) !!}
                    {!! Form::hidden('devsuite_id', $task->devsuite_id) !!}
                    {!! Form::hidden('project_id', $task->project_id) !!}
                   <?php  //huayan
                        $bentitles=\DB::select("SELECT bentitset.ben_title_id FROM bentitset INNER JOIN tasks ON bentitset.task_id = tasks.id where tasks.id=$task->id");
                        $benArray=[];
                        foreach($bentitles as $bentit){
                            $benArray[]=$bentit->ben_title_id;
                        }
                        $bentits=implode('|',$benArray);
                    ?>

                    {!! Form::hidden('bentitle',$bentits)  !!}
                    {!! Form::hidden('project_id', $task->project_id) !!}
                    <?php $assigned_to = $task->tasktype->assigned_to;?>
                    <div class="callout callout-info col-sm-12">
                        @lang('view.Ask')
                        {!! Form::select('assigned_to',[$assigned_to=>$assigned_to?$task->tasktype->assignedto->name:null], null, ['class' => 'form-control select2-ajax-users','required'=>'required','style'=>'width: 100px;']) !!}
                        @lang('view.Handling/Assistance')
                        {!! Form::select('tasktype_id',$task->tasktype->tasktype_select, null, ['class' => 'form-control','required'=>'required','placeholder'=>trans('view.Select task type'),'style'=>'width: 135px;']) !!}
                        @lang('view.Task'), @lang('view.Task Title:')
                        {!! Form::textarea('title', $task->first_task->title.'('.$task->user->name.trans('view. Ask Help').')', ['class' => 'form-control','required'=>'required','rows'=>'1','cols'=>'55']) !!}
                        {!! Form::submit(trans('view.Submit'), ['class' => 'btn btn-primary']) !!}
                    </div>
                    @section('scripts')
                        <script type="text/javascript">
                            select2(".select2-ajax-users","/tasks/usersajaxlist")
                        </script>
                    @endsection
                    {!! Form::close() !!}
                    </div>
                @endif
                </div>
                <div class="row" style="padding-left: 20px">
                    @include('tasks.show_fields')
                </div>
            </div>
        </div>
        @include('tasks.show_sub_fields')
    </div>
@endsection
