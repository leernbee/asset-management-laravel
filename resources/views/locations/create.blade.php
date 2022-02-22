@extends('layouts.dashboard')

@section('title', 'Locations')

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
        Settings
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
        <h3 class="block-title">Create New Location</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('locations.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::open(array('route' => 'locations.store','method'=>'POST')) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Location Name</label>
              {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control form-control-alt' . ( $errors->has('name') ? ' is-invalid' : '' ))) !!}
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Parent</label>
              {!! Form::select('parent_id', $locations,[], array('placeholder' => 'Select a Location','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Manager</label>
              <select class="js-select2 form-control" name="manager_id" style="width: 100%;" data-placeholder="Select a User">
                <option></option>
                @foreach($users as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Address</label>
              {!! Form::text('address1', null, array('class' => 'form-control form-control-alt')) !!}
            </div>
            <div class="form-group">
              {!! Form::text('address2', null, array('class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>City</label>
              {!! Form::text('city', null, array('class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>State</label>
              {!! Form::text('state', null, array('class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Country</label>
              {!! Form::select('country', $countries,[], array('placeholder' => 'Select a Country','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Zip</label>
              {!! Form::text('zip', null, array('class' => 'form-control form-control-alt')) !!}
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