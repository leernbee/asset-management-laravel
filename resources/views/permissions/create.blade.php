@extends('layouts.dashboard')

@section('title', 'Permissions')

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
        <h3 class="block-title">Add Permission</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('permissions.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::open(array('route' => 'permissions.store','method'=>'POST')) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Permission Name</label>
              {!! Form::text('name', null, array('placeholder' => 'Permission Name','class' => 'form-control form-control-alt' . ( $errors->has('name') ? ' is-invalid' : '' ))) !!}
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Assign to Role</label>
              <br />
              @if(!$roles->isEmpty())
              @foreach ($roles as $role)
              <div class="custom-control custom-switch custom-control-success mb-1">
                <input type="checkbox" class="custom-control-input" id="custom-success{{ $role->id }}" name="roles[]" value="{{ $role->id }}">
                <label class="custom-control-label" for="custom-success{{ $role->id }}">{{ $role->name }}</label>
              </div>
              @endforeach
              @endif
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection