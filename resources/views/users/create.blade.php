@extends('layouts.dashboard')

@section('title', 'Users')

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
        Users Management
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
        <h3 class="block-title">Create User</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('users.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">
        {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>First Name</label>
              {!! Form::text('first_name', null, array('placeholder' => 'First Name','class' => 'form-control form-control-alt' . ( $errors->has('first_name') ? ' is-invalid' : '' ))) !!}
              @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Last Name</label>
              {!! Form::text('last_name', null, array('placeholder' => 'Last Name','class' => 'form-control form-control-alt' . ( $errors->has('last_name') ? ' is-invalid' : '' ))) !!}
              @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Username</label>
              {!! Form::text('username', null, array('placeholder' => 'Username','class' => 'form-control form-control-alt' . ( $errors->has('username') ? ' is-invalid' : '' ))) !!}
              @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Email</label>
              {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control form-control-alt' . ( $errors->has('email') ? ' is-invalid' : '' ))) !!}
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Password</label>
              {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control form-control-alt' . ( $errors->has('password') ? ' is-invalid' : '' ))) !!}
              @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Confirm Password</label>
              {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Date of Birth (optional)</label>
              <input type="text" class="js-datepicker form-control form-control-alt" id="birth_date" name="birth_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" data-date-end-date="0d" placeholder="mm-dd-yyyy" value="{{ old('birth_date') }}">
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Contact No. (optional)</label>
              {!! Form::text('contact_no', null, array('placeholder' => '639','class' => 'form-control form-control-alt' . ( $errors->has('contact_no') ? ' is-invalid' : '' ))) !!}
              @error('contact_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Employee ID</label>
              {!! Form::text('employee_id', null, array('placeholder' => 'Employee ID','class' => 'form-control form-control-alt' . ( $errors->has('employee_id') ? ' is-invalid' : '' ))) !!}
              @error('employee_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Job Title (optional)</label>
              {!! Form::text('job_title', null, array('placeholder' => 'Job Title','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Location</label>
              {!! Form::select('location_id', $locations,[], array('class' => 'form-control form-control-alt' . ( $errors->has('location_id') ? ' is-invalid' : '' ))) !!}
              @error('location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Role</label>
              {!! Form::select('roles[]', $roles,[], array('class' => 'form-control form-control-alt' . ( $errors->has('roles') ? ' is-invalid' : '' ),'multiple')) !!}
              @error('roles')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Notes (optional)</label>
              {!! Form::textarea('notes', null, array('id'=>'summernote', 'placeholder' => 'Notes','class' => 'form-control form-control-alt')) !!}
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