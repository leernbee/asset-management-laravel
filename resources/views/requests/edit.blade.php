@extends('layouts.dashboard')

@section('title', 'Requests')

@section('css_before')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" integrity="sha256-CLMYHViXNCxDUd/ySLeJJjyLtteBZwjqZ4c5p6U7L78=" crossorigin="anonymous" />
@endsection

@section('js_after')
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.min.js" integrity="sha256-jPK1ABk4CuFvSr31v4CLU7X7XCvixZSi8fTTCw/tsto=" crossorigin="anonymous"></script>
<script>
  $(document).ready(function() {
    $('#summernote').summernote({
      height: 300,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['para', ['ul', 'ol', 'paragraph']]
      ]
    });
  });
</script>
@endsection

@section('hero')
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
      <h1 class="flex-sm-fill h3 my-2">
        Requests
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
        <h3 class="block-title">Edit Request</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('requests.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">
        {!! Form::model($userRequest, ['method' => 'PATCH','route' => ['requests.update', $userRequest->id]]) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Request Title</label>
              {!! Form::text('title', null, array('placeholder' => 'Request Title','class' => 'form-control form-control-alt' . ( $errors->has('title') ? ' is-invalid' : '' ))) !!}
              @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Description</label>
              {!! Form::textarea('description', null, array('id'=>'summernote', 'placeholder' => 'Description','class' => 'form-control form-control-alt' . ( $errors->has('description') ? ' is-invalid' : '' ))) !!}
              @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Priority</label>
              <div>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-outline-primary btn-toggle {{ $userRequest->priority == 'None' ? 'active' : '' }}">
                    <input type="radio" name="priority" id="option1" value="None" autocomplete="off" {{ $userRequest->priority == 'None' ? 'checked' : '' }}> None
                  </label>
                  <label class="btn btn-outline-primary btn-toggle {{ $userRequest->priority == 'Low' ? 'active' : '' }}">
                    <input type="radio" name="priority" id="option2" value="Low" autocomplete="off" {{ $userRequest->priority == 'Low' ? 'checked' : '' }}> Low
                  </label>
                  <label class="btn btn-outline-primary btn-toggle {{ $userRequest->priority == 'Medium' ? 'active' : '' }}">
                    <input type="radio" name="priority" id="option3" value="Medium" autocomplete="off" {{ $userRequest->priority == 'Medium' ? 'checked' : '' }}> Medium
                  </label>
                  <label class="btn btn-outline-primary btn-toggle {{ $userRequest->priority == 'High' ? 'active' : '' }}">
                    <input type="radio" name="priority" id="option3" value="High" autocomplete="off" {{ $userRequest->priority == 'High' ? 'checked' : '' }}> High
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Assign a Worker</label>
              {!! Form::select('worker_id', $workers, $userRequest->worker_id, array('placeholder'=> 'Select a Worker', 'class' => 'form-control form-control-alt' . ( $errors->has('worker_id') ? ' is-invalid' : '' ))) !!}
              @error('worker_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>

          @if($userRequest->status == 'Pending')
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            {!! Form::submit( 'Approve', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => 'Approve'])!!}
            {!! Form::submit( 'Reject', ['class' => 'btn btn-danger', 'name' => 'submit', 'value' => 'Reject']) !!}
          </div>
          @else
          <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            {!! Form::submit( 'Update', ['class' => 'btn btn-success', 'name' => 'submit', 'value' => 'Update'])!!}
          </div>
          @endif
        </div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@endsection