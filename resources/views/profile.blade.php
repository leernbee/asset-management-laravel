@extends('layouts.dashboard')

@section('title', 'Profile')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}">
</script>
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
        Your Profile
      </h1>
    </div>
  </div>
</div>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-6">
    @if(Session::has('flash_message'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
      <div class="flex-00-auto">
        <i class="fa fa-fw fa-check"></i>
      </div>
      <div class="flex-fill ml-3">
        <p class="mb-0">{{ Session::get('flash_message') }}</p>
      </div>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
      <div class="flex-fill mr-3">
        @foreach($errors->all() as $error)
        <p class="mb-0">{{ $error }}</p>
        @endforeach
      </div>
      <div class="flex-00-auto">
        <i class="fa fa-fw fa-times-circle"></i>
      </div>
    </div>
    @endif
  </div>
</div>
<form method="post" action="{{ route('profile.updateProfile', $user) }}" enctype="multipart/form-data">
  <div class="row">
    <div class="col-lg-6">
      <div class="block">
        <div class="block-header block-header-default">
          <h3 class="block-title">Basic Info</h3>
        </div>
        <div class="block-content">
          {{ csrf_field() }}
          {{ method_field('patch') }}
          <div class="form-group">
            <h3 class="text-center mb-0">{{ $user->first_name }} {{ $user->last_name }}</h3>
            <div class="text-center mb-2">
              @if(!empty($user->getRoleNames()))
              @foreach($user->getRoleNames() as $v)
              <label class="badge badge-success">{{ $v }}</label>
              @endforeach
              @endif
            </div>
            <!-- <label class="d-block" for="avatar">Upload a Profile Photo</label> -->
            <div class="text-center">
              @if(is_null(Auth::user()->getMedia('avatars')->first()))
              <img width="200" src="{{ asset('media/avatars/avatar0.jpg') }}" class="rounded">
              @else
              <img width="200" src="{{ Auth::user()->getMedia('avatars')->first()->getUrl('thumb') }}" class="rounded mb-2 mb-lg-0 mr-3">
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="custom-file">
              <input type="file" class="custom-file-input" data-toggle="custom-file-input" id="avatar" name="avatar" accept="image/jpeg">
              <label class="custom-file-label" for="avatar">Change Profile Photo</label>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="first_name">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $user->first_name }}" placeholder="First Name">
            </div>
            <div class="form-group col-lg-6">
              <label for="last_name">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $user->last_name }}" placeholder="Last Name">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="birth_date">Date of Birth</label>
              <input type="text" class="js-datepicker form-control" id="birth_date" name="birth_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" data-date-end-date="0d" placeholder="mm-dd-yyyy" value="{{ $user->birth_date }}">
            </div>
            <div class="form-group col-lg-6">
              <label for="contact_no">Contact Number (optional)</label>
              <input type="text" class="form-control" id="contact_no" name="contact_no" value="{{ $user->contact_no }}" placeholder="639">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-lg-6">
              <label for="employee_id">Employee ID</label>
              <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ $user->employee_id }}" placeholder="Employee ID">
            </div>
            <div class="form-group col-lg-6">
              <label for="job_title">Job Title</label>
              <input type="text" class="form-control" id="job_title" name="job_title" value="{{ $user->job_title }}" placeholder="Job Title">
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary">
              Save and Update
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection