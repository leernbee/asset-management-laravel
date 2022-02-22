@extends('layouts.dashboard')

@section('title', 'Licenses')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" integrity="sha256-CLMYHViXNCxDUd/ySLeJJjyLtteBZwjqZ4c5p6U7L78=" crossorigin="anonymous" />
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.min.js" integrity="sha256-jPK1ABk4CuFvSr31v4CLU7X7XCvixZSi8fTTCw/tsto=" crossorigin="anonymous"></script>
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script>
  jQuery(function() {
    One.helpers(['datepicker', 'notify']);
  });
  $(document).ready(function() {
    $('#summernote').summernote({
      height: 300,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']]
      ]
    });
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
        <h3 class="block-title">Create New License</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('licenses.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::open(array('route' => 'licenses.store','method'=>'POST')) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Software Name</label>
              {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control form-control-alt' . ( $errors->has('name') ? ' is-invalid' : '' ))) !!}
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Manufacturer</label>
              {!! Form::text('manufacturer', null, array('placeholder' => 'Manufacturer','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Software Type</label>
              {!! Form::select('software_type_id', $software_types,[], array('class' => 'form-control form-control-alt' . ( $errors->has('software_type_id') ? ' is-invalid' : '' ))) !!}
              @error('software_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Version</label>
              {!! Form::text('version', null, array('placeholder' => 'Version','class' => 'form-control form-control-alt' . ( $errors->has('version') ? ' is-invalid' : '' ))) !!}
              @error('version')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Vendor</label>
              {!! Form::text('vendor', null, array('placeholder' => 'Vendor','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Product Key</label>
              {!! Form::textarea('product_key', null, array('placeholder' => 'Product Key','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Seats</label>
              {!! Form::number('seats', null, array('placeholder' => '1', 'class' => 'form-control form-control-alt' . ( $errors->has('seats') ? ' is-invalid' : '' ))) !!}
              @error('seats')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>License to Name</label>
              {!! Form::text('license_name', null, array('placeholder' => 'License to Name','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>License to Email</label>
              {!! Form::text('license_email', null, array('placeholder' => 'License to Email','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Purchase Date</label>
              <input type="text" class="js-datepicker form-control form-control-alt" id="purchase_date" name="purchase_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" placeholder="mm-dd-yyyy">
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Expiration Date</label>
              <input type="text" class="js-datepicker form-control form-control-alt" id="expiration_date" name="expiration_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" placeholder="mm-dd-yyyy">
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Notes</label>
              {!! Form::textarea('notes', null, array('id'=> 'summernote', 'placeholder' => 'Notes','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection