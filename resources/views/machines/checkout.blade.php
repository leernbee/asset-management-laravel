@extends('layouts.dashboard')

@section('title', 'Machines')

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

    $('#checkout-user').on('click', function() {
      $('#checkout-user').addClass('active');
      $('#checkout-location').removeClass('active');

      $('#checkout-user-row').toggleClass('d-none');
      $('#checkout-location-row').toggleClass('d-none');

      $('#checkout-location-select').prop('selectedIndex', 0);
    });

    $('#checkout-location').on('click', function() {
      $('#checkout-location').addClass('active');
      $('#checkout-user').removeClass('active');

      $('#checkout-location-row').toggleClass('d-none');
      $('#checkout-user-row').toggleClass('d-none');

      $('#checkout-user-select').prop('selectedIndex', 0);
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
        <h3 class="block-title">Checkout Machine</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('machines.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::open(array('route' => 'machines.checkout', 'method'=>'POST')) !!}
        <input type="hidden" value="{{ $machine->id }}" name="machine_id">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Machine Tag:</strong>
              {{ $machine->machine_tag }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Name:</strong>
              {{ $machine->name }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Serial:</strong>
              {{ $machine->serial }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Checkout to</strong>
              <div class="btn-group" role="group" aria-label="Horizontal Primary">
                <button id="checkout-user" type="button" class="active btn btn-primary">User</button>
                <button id="checkout-location" type="button" class="btn btn-primary">Location</button>
              </div>
            </div>
          </div>
          <div id="checkout-user-row" class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>User</label>
              <select class="js-select2 form-control @error('user_id') is-invalid @enderror" id="checkout-user-select" name="user_id" style="width: 100%;" data-placeholder="Select a User">
                <option></option>
                @foreach($users as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
              </select>
              @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div id="checkout-location-row" class="d-none col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Location</label>
              {!! Form::select('location_id', $locations,[], array('placeholder' => 'Select a Location', 'id' => 'checkout-location-select', 'class' => 'form-control form-control-alt' . ( $errors->has('location_id') ? ' is-invalid' : '' ))) !!}
              @error('location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Checkout Date</label>
              <input type="text" class="js-datepicker form-control form-control-alt @error('checkout_date') is-invalid @enderror" id="checkout_date" name="checkout_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" data-date-end-date="0d" placeholder="mm-dd-yyyy">
              @error('checkout_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
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