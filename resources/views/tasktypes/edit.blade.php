@extends('layouts.app')

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <section class="content-header">
           <h1>
               @lang('view.edit')@lang('view.Tasktype Eav')
           </h1>
       </section>
       <div class="box box-primary">
           <div class="box-body">
               <table class="table">
                   <thead>
                   <tr>
                       <th>@lang('db.frontend_label')</th>
                       <th>@lang('db.frontend_input')</th>
                       <th>@lang('db.frontend_size')</th>
                       <th>@lang('db.is_required')</th>
                       <th>@lang('db.is_unique')</th>
                       <th>@lang('db.option')</th>
                       <th>@lang('db.orderby')</th>
                       <th colspan="2"><a class="btn btn-primary pull-right" href="{!! route('tasktypeEavs.create') !!}/{!! $tasktype->id !!}">@lang('view.Add New')</a></th>
                   </tr>
                   </thead>
                   <tbody>
                   @foreach($tasktypeeav as $attribute)
                       <tr>
                           <td>{{ $attribute->frontend_label }}</td>
                           <td>{{ $attribute->frontend_input }}</td>
                           <td>{{ number_format($attribute->frontend_size/12*100) }}%@lang('view.Width')</td>
                           <td>{{ $attribute->is_required==1?'Yes':'No' }}</td>
                           <td>{{ $attribute->is_unique==1?'Yes':'No' }}</td>
                           <td>{{ $attribute->option }}</td>
                           <td>{{ $attribute->orderby }}</td>
                           <td width="80"><a class="btn btn-primary" href="{{ URL::route('tasktypeEavs.edit', $attribute->id) }}">@lang('view.Edit')</a></td>
                           <td width="80">{!! Form::open(['route' => ['tasktypeEavs.update', $attribute->id], 'method' => 'DELETE']) !!}
                               {!! Form::submit(trans('view.Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");']) !!}
                               {!!  Form::close() !!}</td>
                       </tr>
                   @endforeach
                   </tbody>
               </table>
           </div>
       </div>

       <section class="content-header">
           <h1>
               @lang('view.edit')@lang('view.Tasktype')
           </h1>
       </section>
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($tasktype, ['route' => ['tasktypes.update', $tasktype->id], 'method' => 'patch']) !!}

                   @include('tasktypes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
           <div class="clearfix"></div>
       </div>
   </div>
@endsection