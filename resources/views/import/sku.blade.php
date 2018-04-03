@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            @lang('view.create') SKU @lang('view.Import') - JD
            <a href="{!! route('tasks.index') !!}" class="btn btn-default">@lang('view.Back')</a>
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="row">
           <div class="col-md-4">
               <div class="box box-default">
                   <div class="box-header with-border">
                       <h3 class="box-title">@lang('view.Step') 1</h3>
                   </div>
                   <div class="box-body">
                       {!! Form::open(['route' => ['import.sku2jd'],'onsubmit'=>'javascript:$("#btnsubmit").attr("disabled","disabled")']) !!}
                       <div class="form-group col-sm-12">
                           {!! Form::label('SKU', 'SKU:') !!}
                           {!! Form::textarea('SKU', null, ['class' => 'form-control','style'=>'height:350px','required']) !!}
                       </div>

                       <!-- Submit Field -->
                       <div class="form-group col-sm-12">
                           {!! Form::submit(trans('view.Import'), ['class' => 'btn btn-primary','id'=>'btnsubmit']) !!}
                           <a href="{!! route('tasks.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
                       </div>
                       {!! Form::close() !!}
                   </div>
               </div>
           </div>
           <div class="col-md-8">
               <div class="box box-success">
                   <div class="box-header with-border">
                       <h3 class="box-title">@lang('view.Step') 2</h3>
                   </div>
                   <div class="box-body">
                       @include('flash::message')
                       @if(isset($jdSKU))
                       {!! Form::open(['route' => ['import.jd2task'],'onsubmit'=>'javascript:$("#btnsubmit").attr("disabled","disabled")']) !!}
                       <div class="form-group col-sm-12">
                           <table class="table">
                               <thead>
                               <tr>
                                   <th>@lang('db.SKU')</th>
                                   <th>@lang('db.Name')</th>
                                   <th>@lang('db.Brand')</th>
                                   <th>@lang('db.Image')</th>
                                   {{--<th colspan="2"></th>--}}
                               </tr>
                               </thead>
                               <tbody>
                               @foreach($jdSKU as $prd)
                                   <tr id="prd{{ $prd['sku'] }}">
                                       <td>{{ $prd['sku'] }}<br/>
                                           <input type="checkbox" name="jd[{{ $prd['sku'] }}][ready]" checked />@lang('view.Confirmed')
                                           <input type="hidden" name="jd[{{ $prd['sku'] }}][sku]" value="{{ $prd['sku'] }}"/></td>
                                       <td>{{ $prd['name'] }}
                                           <input type="hidden" name="jd[{{ $prd['sku'] }}][name]" value="{{ $prd['name'] }}"/></td>
                                       <td>{{ $prd['brand'] }}
                                           <input type="hidden" name="jd[{{ $prd['sku'] }}][brand]" value="{{ $prd['brand'] }}"/></td>
                                       <td><img src="{{ $prd['image'] }}" style="width: 150px;" />
                                           <input type="hidden" name="jd[{{ $prd['sku'] }}][image]" value="{{ $prd['image'] }}"/></td>
                                   {{--<td width="80"><a class="btn btn-primary" href="{{ URL::route('users.edit', $user->id) }}">@lang('view.edit')</a></td>--}}
                                   {{--<td width="80">{!! Form::open(['route' => ['users.update', $user->id], 'method' => 'DELETE']) !!}--}}
                                   {{--{!! Form::submit(trans('view.Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirm("Are you sure?");']) !!}--}}
                                   {{--{!!  Form::close() !!}</td>--}}
                                   </tr>
                               @endforeach
                               </tbody>
                           </table>
                       </div>
                       <!-- Submit Field -->
                       <div class="form-group col-sm-12">
                           {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary','id'=>'btnsubmit']) !!}
                           <a href="{!! route('tasks.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
                       </div>
                       {!! Form::close() !!}
                       @endif
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection