@extends('layouts.dashboard')

@section('title', 'Verify Account')

@section('js_after')

@endsection

@section('content')
<div class="col-md-12 col-lg-8 mx-auto">
  <div class="block">
    <div class="block-header block-header-default">
      <h3 class="block-title">Verify Your E-mail Address</h3>
    </div>
    <div class="block-content">
      @if (session('resent'))
      <div class="alert alert-success d-flex align-items-center" role="alert">
        <div class="flex-00-auto">
          <i class="fa fa-fw fa-check"></i>
        </div>
        <div class="flex-fill ml-3">
          <p class="mb-0">{{ __('A fresh verification link has been sent to your email address.') }}</p>
        </div>
      </div>
      @endif

      <p class="mb-0">{{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},</p>
      <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf

        <div class="form-group">
          <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </div>
      </form>
    </div>
  </div>
</div>
@endsection