@extends('layouts.auth')

@section('title', 'SMS Verify')

@section('js_after')

@endsection

@section('content')
<!-- Page Content -->
<div class="hero-static d-flex align-items-center">
  <div class="w-100">
    <!-- Sign In Section -->
    <div class="content content-full bg-white">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4 py-4">
          <!-- Header -->
          <div class="text-center">
            <p class="mb-2">
              <i class="fa fa-2x fa-circle-notch text-primary"></i>
            </p>
            <h1 class="h4 mb-3">
              SMS Verification
            </h1>
          </div>
          <!-- END Header -->

          <form class="" action="{{ route('smsVerify') }}" method="POST">
            @csrf

            <div class="py-3">
              <div class="form-group">
                <input type="text" class="form-control form-control-lg form-control-alt @if ($errors->has('code')) is-invalid @endif" id="code" name="code" value="{{ old('code') }}" required autofocus>
                @if ($errors->has('code'))
                <div class="invalid-feedback">{{ $errors->first('code') }}</div>
                @endif
              </div>

            </div>
            <div class="form-group row justify-content-center mb-0">
              <div class="col-md-6 col-xl-6">
                <button type="submit" class="btn btn-block btn-primary">
                  Verify Account
                </button>
              </div>
            </div>
          </form>
          <!-- END Sign In Form -->
        </div>
      </div>
    </div>
    <!-- END Sign In Section -->

    <!-- Footer -->
    <div class="font-size-sm text-center text-muted py-3">
      <strong>{{ config('app.name') }}</strong> &copy; <span data-toggle="year-copy"></span>
    </div>
    <!-- END Footer -->
  </div>
</div>
<!-- END Page Content -->
@endsection