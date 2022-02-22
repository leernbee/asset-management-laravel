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
        <h3 class="block-title">Edit Role</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('roles.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Role Name</label>
              {!! Form::text('name', null, array('placeholder' => 'Role Name','class' => 'form-control form-control-alt' . ( $errors->has('name') ? ' is-invalid' : '' ))) !!}
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Permission</label>

              @foreach($permission as $value)
              <div class="custom-control custom-switch custom-control-{{ $errors->has('permission') ? 'danger' : 'success' }} mb-1">
                <input {{ in_array($value->id, $rolePermissions) && !$errors->has('permission') ? 'checked' : '' }} type="checkbox" class="custom-control-input" id="custom-success{{ $value->id }}" name="permission[]" value="{{ $value->id }}">
                <label class="custom-control-label" for="custom-success{{ $value->id }}">{{ $value->name }}</label>
              </div>
              @endforeach
              @error('permission')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Update</button>
          </div>
        </div>
        {!! Form::close() !!}

      </div>
    </div>
  </div>
</div>
@endsection