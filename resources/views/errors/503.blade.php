@extends('layouts.auth')

@section('title', 'Maintenance')

@section('js_after')

@endsection

@section('css_after')

@endsection

@section('content')
<!-- Page Content -->
<div class="hero-static d-flex align-items-center">
  <div class="w-100">
    <!-- Maintenance Section -->
    <div class="content content-full bg-white">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-4 py-6">
          <!-- Header -->
          <div class="text-center">
            <p>
              <i class="fa fa-3x fa-cog fa-spin text-primary"></i>
            </p>
            <h1 class="h4 mb-1">
              Sorry, we’re down for maintenance..
            </h1>
            <h2 class="h6 font-w400 text-muted mb-3">
              ..but we’ll be back shortly!
            </h2>
          </div>
          <!-- END Header -->
        </div>
      </div>
    </div>
    <!-- END Maintenance Section -->

    <!-- Footer -->
    <div class="font-size-sm text-center text-muted py-3">
      <strong>{{ config('app.name') }}</strong> &copy; <span data-toggle="year-copy"></span>
    </div>
    <!-- END Footer -->
  </div>
</div>
<!-- END Page Content -->
@endsection