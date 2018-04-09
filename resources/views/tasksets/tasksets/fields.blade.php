<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', (!Request::is('reports/create')) ? $report->name : null, ['class' => 'form-control']) !!}
</div>

<!-- Desc Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('desc', 'Desc:') !!}
    {!! Form::textarea('desc', (!Request::is('reports/create')) ? $report->desc : null, ['class' => 'form-control']) !!}
</div>

<!-- Rules Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('rules', 'Rules:') !!}
    {!! Form::textarea('rules', (!Request::is('reports/create')) ? $report->rules : null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit(trans('view.Save'), ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('reports.index') !!}" class="btn btn-default"> @lang('view.Cancel')</a>
</div>
