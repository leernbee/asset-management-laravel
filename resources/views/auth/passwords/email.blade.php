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
                        <h1 class="h4 mb-1">
                            Reset your password
                        </h1>
                        <h2 class="h6 font-w400 text-muted mb-3">
                            <a href="/login">Back to Sign in</a>
                        </h2>
                    </div>
                    <!-- END Header -->
                    @if (session('status'))
                    <div class="pt-3">
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <div class="flex-00-auto">
                                <i class="fa fa-fw fa-check"></i>
                            </div>
                            <div class="flex-fill ml-3">
                                <p class="mb-0">{{ session('status') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form class="" action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="py-3">
                            <div class="form-group">

                                <input type="text" class="form-control form-control-lg form-control-alt @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="E-mail Address">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row justify-content-center mb-0">
                            <div class="col-md-10 col-lg-8">
                                <button type="submit" class="btn btn-block btn-primary">
                                    Send me instructions
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