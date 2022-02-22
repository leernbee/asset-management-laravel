@extends('layouts.dashboard')

@section('title', 'Status')

@section('css_before')

@endsection

@section('js_after')

@endsection

@section('hero')
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
      <h1 class="flex-sm-fill h3 my-2">
        Assets Management
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
        <h3 class="block-title">Edit Status</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('status.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::model($status, ['method' => 'PATCH','route' => ['status.update', $status->id]]) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Name</label>
              {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control form-control-alt' . ( $errors->has('name') ? ' is-invalid' : '' ))) !!}
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Type</label>
              {!! Form::select('type', ['Deployable' => 'Deployable', 'Pending' => 'Pending', 'Undeployable' => 'Undeployable'], $status->type, array('placeholder' => 'Select a Type', 'class' => 'form-control form-control-alt' . ( $errors->has('type') ? ' is-invalid' : '' ))) !!}
              @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Description</label>
              {!! Form::textarea('desc', null, array('placeholder' => 'Description','class' => 'form-control form-control-alt')) !!}
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