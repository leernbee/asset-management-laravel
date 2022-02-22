@extends('layouts.dashboard')

@section('title', 'Preferences')

@section('js_after')
<script src="{{ asset('js/pages/preferences.js') }}"></script>
@endsection

@section('hero')
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
      <h1 class="flex-sm-fill h3 my-2">
        Your Settings
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
<div class="row">
  <div class="col-lg-6">
    <div class="block">
      <div class="block-header block-header-default">
        <h3 class="block-title">Account</h3>
      </div>
      <div class="block-content">
        <h4 class="font-w400">Your Username</h4>
        <div id="update-username">
          <p>{{ $user->username }}</p>
          <p>
            <a id="link-update-username" href="javascript:void(0)">Update Username</a>
          </p>
        </div>
        <div id="form-update-username" class="d-none">
          <form method="post" action="{{ route('preferences.updateUsername', $user) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <div class="form-group row">
              <div class="col-lg-6">
                <label for="new-username">New Username</label>
                <input type="username" class="form-control" id="new-username" name="username" value="{{ $user->username }}">
              </div>
              <div class="col-lg-6">
                <label for="current">Your Current Password</label>
                <input type="password" class="form-control" id="current" name="current">
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Save and Update
              </button>
              <button id="cancel-update-username" type="button" class="btn btn-link">
                Cancel
              </button>
            </div>
          </form>
        </div>
        <hr>
        <h4 class="font-w400">Your Email</h4>
        <div id="update-email">
          <p>{{ $user->email }}</p>
          <p>
            <a id="link-update-email" href="javascript:void(0)">Update Email</a>
          </p>
        </div>
        <div id="form-update-email" class="d-none">
          <form method="post" action="{{ route('preferences.updateEmailAddress', $user) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <div class="form-group row">
              <div class="col-lg-6">
                <label for="new-email">New Email Address</label>
                <input type="email" class="form-control" id="new-email" name="email" value="{{ $user->email }}">
              </div>
              <div class="col-lg-6">
                <label for="current">Your Current Password</label>
                <input type="password" class="form-control" id="current" name="current">
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Save and Update
              </button>
              <button id="cancel-update-email" type="button" class="btn btn-link">
                Cancel
              </button>
            </div>
          </form>
        </div>
        <hr>
        <h4 class="font-w400">Your Password</h4>
        <div id="update-password">
          <p>*********</p>
          <p>
            <a id="link-update-password" href="javascript:void(0)">Update Password</a>
          </p>
        </div>
        <div id="form-update-password" class="d-none">
          <form method="post" action="{{ route('preferences.updatePassword', $user) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <div class="form-group row">
              <div class="col-lg-6">
                <label for="current">Your Current Password</label>
                <input type="password" class="form-control" id="current" name="current">
              </div>
            </div>
            <div class="form-group row">
              <div class="col-lg-6">
                <label for="password">New Password</label>
                <input type="password" class="form-control" id="password" name="password">
              </div>
              <div class="col-lg-6">
                <label for="confirm-password">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm-password" name="password_confirmation">
              </div>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">
                Set New Password
              </button>
              <button id="cancel-update-password" type="button" class="btn btn-link">
                Cancel
              </button>
            </div>
          </form>
        </div>
        <hr>
        <div id="close-account">
          <p>
            <a id="link-close-account" href="javascript:void(0)">Close Your Account</a>
          </p>
        </div>
        <div id="form-close-account" class="d-none">
          <p>Are you sure you want to close your account? You’ll lose your application history, and renter profile.</p>
          <form method="post" action="{{ route('preferences.closeAccount', $user) }}">
            {{ csrf_field() }}
            {{ method_field('patch') }}
            <div class="form-group">
              <label for="confirm-delete">Confirm by typing ‘delete’</label>
              <input type="text" class="form-control" id="confirm-delete" name="delete">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-outline-danger">
                Close Account
              </button>
              <button id="cancel-close-account" type="button" class="btn btn-link">
                Cancel
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-6">
    <div class="block">
      <div class="block-header block-header-default">
        <h3 class="block-title">Security</h3>
      </div>
      <div class="block-content">
        <h4 class="font-w400">2-step verification</h4>
        <p>2-step verification adds an extra layer of security to your account by helping ensure you're the only person who can access your account, even if someone knows your password. When enabled, we'll verify your account every time you log in by sending a temporary code to your mobile number.</p>
        @if (Auth::user()->sms_2fa_enable)
        <p>
          <a href="{{ url('2fa/disable') }}" class="btn btn-warning">Disable 2FA</a>
          @else
          <a href="{{ url('2fa/enable') }}" class="btn btn-primary">Enable 2FA</a>
          @endif
        </p>
      </div>
    </div>
  </div>
</div>
@endsection