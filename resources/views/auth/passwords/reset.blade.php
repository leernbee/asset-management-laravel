@extends('layouts.auth')

@section('title', 'Reset your Password')

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
                            Reset your password
                        </h1>
                    </div>
                    <!-- END Header -->

                    <form class="" action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="py-3">
                            <div class="form-group">

                                <input type="text" class="form-control form-control-lg form-control-alt @error('email') is-invalid @enderror" id="email" name="email" value="{{ $email ?? old('email') }}" placeholder="E-mail Address">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg form-control-alt @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg form-control-alt" id="password-confirm" name="password_confirmation" placeholder="Password Confirm">
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-0">
                            <div class="col-md-6 col-xl-6">
                                <button type="submit" class="btn btn-block btn-primary">
                                    Reset Password
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