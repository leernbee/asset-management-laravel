@extends('layouts.dashboard')

@section('title', 'Roles')

@section('css_before')

@endsection

@section('js_after')

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
        <h3 class="block-title">Role Details</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('roles.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Role Name: </label>
              {{ $role->name }}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Permission</label>
              <ul>
                @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                <li>{{ $v->name }}</li>
                @endforeach
                @endif
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection