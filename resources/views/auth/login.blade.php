@extends('layouts.auth')

@section('title', 'Sign in')

@section('js_after')
<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<!-- Page JS Code -->
<script src="{{ asset('js/pages/login.js') }}"></script>
@endsection

@section('css_after')
<style>
    .hr-text {
        line-height: 1em;
        position: relative;
        outline: 0;
        border: 0;
        color: black;
        text-align: center;
        height: 1.5em;
        opacity: .5;
    }

    .hr-text:before {
        content: '';
        background: linear-gradient(to right, transparent, #818078, transparent);
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
    }

    .hr-text:after {
        content: attr(data-content);
        position: relative;
        display: inline-block;
        color: black;
        padding: 0 .5em;
        line-height: 1.5em;
        color: #818078;
        background-color: #fcfcfa;
    }
</style>
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
                            Sign in to {{ config('app.name') }}
                        </h1>
                        <!-- <h2 class="h6 font-w400 text-muted mb-3">
                            or, <a href="./register">Create an Account</a>
                        </h2> -->
                    </div>
                    <!-- END Header -->
                    @if ($errors->has('code'))
                    <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <p class="mb-0">{{ $errors->first('code') }}</p>
                        </div>
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-times-circle"></i>
                        </div>
                    </div>
                    @endif

                    <form class="js-validation-login" action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="py-3">
                            <div class="form-group text-center">
                                <a href="{{url('/redirect')}}">
                                    <img height="50px" src="{{ asset('media/btn_google_signin_dark_normal_web@2x.png') }}" alt="Google SignIn">
                                </a>
                                <hr class="hr-text" data-content="OR">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg form-control-alt{{ $errors->has('username') || $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" value="{{ old('email') }}" placeholder="Username/Email Address" value="{{ old('username') ?: old('email') }}" required="" autofocus="">
                                @if ($errors->has('username') || $errors->has('email'))
                                <div class="invalid-feedback">{{ $errors->first('username') ?: $errors->first('email') }}</div>
                                @endif
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-lg form-control-alt @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required autocomplete="current-password">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="d-md-flex align-items-md-center justify-content-md-between">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label font-w400" for="remember">Remember Me</label>
                                    </div>
                                    <div class="py-2">
                                        @if (Route::has('password.request'))
                                        <a class="font-size-sm" href="{{ route('password.request') }}">Forgot Password?</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-0">
                            <div class="col-md-12 col-lg-5 mb-md-0 mb-2">
                                <button type="submit" class="btn btn-block btn-primary">
                                    <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
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