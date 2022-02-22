@extends('layouts.dashboard')

@section('title', 'Machines')

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
        <h3 class="block-title">Checkin Machine</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('machines.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::open(array('route' => 'machines.checkin', 'method'=>'POST')) !!}
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
              <label>Status</label>
              {!! Form::select('status', $statuses, $machine->status_id, array('placeholder' => 'Select a Status', 'class' => 'form-control form-control-alt form-control-alt' . ( $errors->has('status') ? ' is-invalid' : '' ))) !!}
              @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Location</label>
              {!! Form::select('location_id', $locations,[], array('placeholder' => 'Select a Location','class' => 'form-control form-control-alt form-control-alt' . ( $errors->has('location_id') ? ' is-invalid' : '' ))) !!}
              @error('location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Checkin Date</label>
              <input type="text" class="js-datepicker form-control form-control-alt @error('checkin_date') is-invalid @enderror" id="checkin_date" name="checkin_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" placeholder="mm-dd-yyyy">
              @error('checkin_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
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