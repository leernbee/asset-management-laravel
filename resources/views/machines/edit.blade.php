@extends('layouts.dashboard')

@section('title', 'Machines')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" integrity="sha256-CLMYHViXNCxDUd/ySLeJJjyLtteBZwjqZ4c5p6U7L78=" crossorigin="anonymous" />
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.min.js" integrity="sha256-jPK1ABk4CuFvSr31v4CLU7X7XCvixZSi8fTTCw/tsto=" crossorigin="anonymous"></script>
<script>
  jQuery(function() {
    One.helpers(['datepicker']);
  });
</script>
<script>
  $(document).ready(function() {
    var count = 0;

    function dynamic_field(number) {
      html = '<div class="meta-form row">';
      html += '<div class="col-md-5">';
      html += '<div class="form-group">';
      html += '<label>Field Name</label>';
      html += '<input type="text" name="meta_name[]" class="form-control form-control-alt" placeholder="Field Name">';
      html += '</div>';
      html += '</div>';
      html += '<div class="col-md-5">';
      html += '<div class="form-group">';
      html += '<label>Field Value</label>';
      html += '<input type="text" name="meta_value[]" class="form-control form-control-alt" placeholder="Field Value">';
      html += '</div>';
      html += '</div>';
      html += '<div class="col-md-2">';
      html += '<div class="form-group">';
      html += '<label>&nbsp;</label>';
      html += '<button type="button" name="remove" id="" class="btn btn-danger remove d-block"><i class="fa fa-trash"></i></button>';
      html += '</div>';
      html += '</div>';
      html += '</div>';

      $('#meta').append(html);
    }

    $(document).on('click', '#add', function() {
      count++;
      dynamic_field(count);
    });

    $(document).on('click', '.remove', function() {
      count--;
      $(this).closest(".meta-form").remove();
    });

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
        <h3 class="block-title">Edit Machine</h3>
        <div class="block-options">
          <a class="btn-block-option" href="{{ route('machines.index') }}">
            <i class="fa fa-window-close"></i>
          </a>
        </div>
      </div>
      <div class="block-content">

        {!! Form::model($machine, ['method' => 'PATCH','route' => ['machines.update', $machine->id]]) !!}
        <div class="row mb-3">
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Machine Tag</label>
              {!! Form::text('machine_tag', null, array('placeholder' => 'Machine Tag','class' => 'form-control form-control-alt' . ( $errors->has('machine_tag') ? ' is-invalid' : '' ))) !!}
              @error('machine_tag')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Name</label>
              {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control form-control-alt' . ( $errors->has('name') ? ' is-invalid' : '' ))) !!}
              @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Machine Type</label>
              {!! Form::select('machine_type_id', $machine_types, $machine->machine_type_id, array('class' => 'form-control form-control-alt' . ( $errors->has('machine_type_id') ? ' is-invalid' : '' ))) !!}
              @error('machine_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Operating System</label>
              {!! Form::select('operating_system_id', $operating_systems, $machine->operating_system_id, array('class' => 'form-control form-control-alt' . ( $errors->has('operating_system_id') ? ' is-invalid' : '' ))) !!}
              @error('operating_system_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Manufacturer</label>
              {!! Form::text('manufacturer', null, array('placeholder' => 'Manufacturer','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Model</label>
              {!! Form::text('model', null, array('placeholder' => 'Model','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Serial Number</label>
              {!! Form::text('serial', null, array('placeholder' => 'Serial Number','class' => 'form-control form-control-alt' . ( $errors->has('serial') ? ' is-invalid' : '' ))) !!}
              @error('serial')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Support Link</label>
              {!! Form::text('support_link', null, array('placeholder' => 'https://','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <strong>Active Service Date:</strong>
              <input type="text" class="js-datepicker form-control form-control-alt" id="service_date" name="service_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm-dd-yyyy" placeholder="mm-dd-yyyy" value="{{ $machine->service_date }}">
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Status</label>
              {!! Form::select('status_id', $statuses, $machine->status_id, array('class' => 'form-control form-control-alt' . ( $errors->has('status_id') ? ' is-invalid' : '' ))) !!}
              @error('status_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Default Location</label>
              {!! Form::select('location_id', $locations, $machine->location_id, array('class' => 'form-control form-control-alt' . ( $errors->has('location_id') ? ' is-invalid' : '' ))) !!}
              @error('location_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
              <label>Notes</label>
              {!! Form::textarea('notes', null, array('id'=> 'summernote', 'placeholder' => 'Notes','class' => 'form-control form-control-alt')) !!}
            </div>
          </div>

          <div class="col-lg-12">
            <div class="block block-bordered">
              <div class="block-header">
                <h3 class="block-title">Additional Fields</h3>
                <div class="block-options">
                  <button type="button" name="add" id="add" class="btn btn-success btn-sm">Add</button>
                </div>
              </div>
              <div class="block-content">
                <div id="meta" class="col-xs-12 col-sm-12 col-md-12">
                  @foreach($metas as $key => $meta)
                  <div class="meta-form row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Field Name</label>
                        <input type="text" name="meta_name[]" class="form-control form-control-alt" value="{{ $key }}" placeholder="Field Name">
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Field Value</label>
                        <input type="text" name="meta_value[]" class="form-control form-control-alt" value="{{ $meta }}" placeholder="Field Value">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="button" name="remove" id="" class="btn btn-danger remove d-block"><i class="fa fa-trash"></i></button>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
              </div>
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