@extends('layouts.dashboard')

@section('title', 'Licenses')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}">
</script>
<script src="{{ asset('js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
  jQuery(function() {
    One.helpers(['datepicker', 'notify']);
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
  <div class="col-lg-12">
    <div class="block">
      <div class="block-header">
        <h3 class="block-title">Manage Licenses</h3>
        <div class="block-options">
          @can('Create licenses')
          <a href="{{ route('licenses.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-fw fa-plus mr-1"></i> Add License
          </a>
          @endcan
        </div>
      </div>
      <div class="block-content">
        @if ($message = Session::get('success'))
        @push('scripts')
        <script>
          jQuery(function() {
            One.helpers('notify', {
              type: 'success',
              icon: 'fa fa-check mr-1',
              message: "{{ $message }}"
            });
          });
        </script>
        @endpush
        @endif

        {!! Form::open(['method'=>'get']) !!}
        <div class="row">
          <div class="col-md-4 col-lg-3 form-group">
            {!! Form::select('type',$softwareList,$type,['class'=>'form-control','onChange'=>'form.submit()']) !!}
          </div>
          <div class="ml-auto col-md-5 col-lg-4 form-group">
            <div class="input-group">
              <input type="text" class="form-control" id="search" name="search" placeholder="Search Name or Vendor" value="{{ request('search') }}">
              <div class="input-group-append">
                <button type="submit" class="btn btn-info">
                  <i class="fa fa-search mr-1"></i> Search
                </button>
              </div>
            </div>
          </div>
          <input type="hidden" value="{{request('field')}}" name="field" />
          <input type="hidden" value="{{request('sort')}}" name="sort" />
        </div>
        {!! Form::close() !!}

        <div class="table-responsive">
          <table class="table table-bordered table-striped table-vcenter">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>
                  <a href="{{url('licenses')}}?search={{request('search')}}&type={{request('type')}}&field=name&sort={{request('sort','asc')=='asc'?'desc':'asc'}}">
                    Name
                  </a>
                  {{request('field')=='name'?(request('sort','asc')=='asc'?'▴':'▾'):''}}
                </th>
                <th>Type</th>
                <th>Seats</th>
                <th class="text-center" style="width: 250px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($data as $key => $license)
              <tr>
                <th class="text-center" scope="row">{{ ++$i }}</th>
                <td class="font-w600 font-size-sm">
                  <a href="{{ route('licenses.show',$license->id) }}">{{ $license->name }}</a>
                </td>
                <td>{{ $license->software_type->name }}</td>
                <td>{{ $license->seats }}</td>
                <td class="text-center">
                  @can('Install/Uninstall licenses')
                  @if ( $license->seats > 0 )
                  <a class="btn btn-secondary" href="{{ route('licenses.installview',$license->id) }}">Install</a>
                  @else
                  <a class="btn btn-secondary disabled" href="#">Install</a>
                  @endif
                  @endcan
                  @can('Edit licenses')
                  <a class="btn btn-primary" href="{{ route('licenses.edit',$license->id) }}"><i class="fa fa-edit"></i></a>
                  @endcan
                  @can('Delete licenses')
                  {!! Form::open(['class' => 'license-delete', 'method' => 'DELETE','route' => ['licenses.destroy', $license->id],'style'=>'display:inline']) !!}
                  {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] )  }}
                  {!! Form::close() !!}
                  @endcan
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">No licenses to show</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {!! $data->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection

@can('Delete licenses')
@push('scripts')
<script>
  $(document).ready(function() {
    $("form.license-delete").submit(function(e) {
      e.preventDefault();

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        buttonsStyling: false,
        customClass: {
          confirmButton: 'btn btn-danger m-1',
          cancelButton: 'btn btn-secondary m-1'
        },
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $(this).off("submit").submit();
        }
      });
    });
  });
</script>
@endpush
@endcan