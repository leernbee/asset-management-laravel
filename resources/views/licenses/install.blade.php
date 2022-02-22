@extends('layouts.dashboard')

@section('title', 'Licenses')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.min.css') }}">
<style>
  .select2-container--default .select2-selection--single {
    border: none;
    border-color: #f5f5f5;
    background-color: #f5f5f5;
  }

  .is-invalid+.select2-container--default .select2-selection--single {
    border: none;
    border-color: #f9eae8;
    background-color: #f9eae8;
  }
</style>
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}">
</script>
<script src="{{ asset('js/plugins/select2/js/select2.full.min.js') }}">
</script>
<script>
  jQuery(function() {
    One.helpers(['datepicker', 'select2']);
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
        <h3 class="block-title">Install License</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('licenses.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::open(array('route' => 'licenses.install', 'method'=>'POST')) !!}
        @csrf
        <input type="hidden" value="{{ $license->id }}" name="license_id">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Software Name:</strong>
              {{ $license->name }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Product Key:</strong>
              {{ $license->product_key }}
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Install To</label>
              <select class="js-select2 form-control @error('machine_id') is-invalid @enderror" name="machine_id" style="width: 100%;" data-placeholder="Select a Machine">
                <option></option>
                @foreach($machines as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
              @error('machine_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Install Date</label>
              <input type="text" class="js-datepicker form-control form-control-alt @error('install_date') is-invalid @enderror" id="install_date" name="install_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" data-date-end-date="0d" placeholder="mm-dd-yyyy">
              @error('install_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
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