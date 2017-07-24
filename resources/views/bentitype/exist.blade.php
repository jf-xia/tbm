@extends('layouts.app')

@section('content')

  <div class="alert alert-warning"><strong></strong>已经存在！</div><div class="modal-footer">
    <a href="{!!route('bentitype.index')!!}" class="btn btn-primary" >确认</a>
  </div>

@endsection