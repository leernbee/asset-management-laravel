@extends('layouts.dashboard')

@section('title', 'Licenses')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script>
  jQuery(function() {
    One.helpers(['datepicker']);
  });
</script>
@endsection

@section('hero')
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
      <h1 class="flex-sm-fill h3 my-2">
        Assets Management
      </h1>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-6">
    <div class="block">
      <div class="block-header">
        <h3 class="block-title">Unnstall License</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('licenses.show', $check->checkable->id) }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::open(array('route' => 'licenses.uninstall', 'method'=>'POST')) !!}
        @csrf
        <input type="hidden" value="{{ $check->checkable->id }}" name="license_id">
        <input type="hidden" value="{{ $check->targetable->id }}" name="machine_id">
        <input type="hidden" value="{{ $check->id }}" name="check_id">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Machine:</strong>
              {{ $check->targetable->machine_tag }} - {{ $check->targetable->name }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Software Name:</strong>
              {{ $check->checkable->name }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Product Key:</strong>
              {{ $check->checkable->product_key }}
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Notes</label>
              {!! Form::textarea('notes', null, array('placeholder' => 'Notes','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>

        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection