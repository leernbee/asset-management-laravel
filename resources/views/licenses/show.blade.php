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
      <ul class="nav nav-tabs nav-tabs-block align-items-center" data-toggle="tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#block-tab-details">Details</a>
        </li>
        <li class="nav-item ml-auto">
          <div class="btn-group btn-group-sm pr-2">
            <div class="btn-group btn-group-sm" role="group">
              <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupTabs1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
              </button>
              <div class="dropdown-menu dropdown-menu-right font-size-sm" aria-labelledby="btnGroupTabs1">
                @if ( $license->seats > 0 )
                <a class="dropdown-item" onclick="installLicense()" href="#">
                  <i class="fa fa-fw fa-compact-disc mr-1"></i> Install</a>
                @else
                <a class="dropdown-item disabled" href="#">
                  <i class="fa fa-fw fa-compact-disc mr-1"></i> Install</a>
                @endif
                <a class="dropdown-item" onclick="editLicense()" href="#">
                  <i class="fa fa-fw fa-pencil-alt mr-1"></i> Edit License
                </a>
                <a id="delete-license-link" class="dropdown-item" onclick="deleteLicense()" href="#">
                  <i class="fa fa-fw fa-trash mr-1"></i> Delete License
                </a>
                {!! Form::open(['class'=>'d-none', 'id' => 'license-delete', 'method' => 'DELETE','route' => ['licenses.destroy', $license->id],'style'=>'display:inline']) !!}
                {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </li>
      </ul>
      <div class="block-content tab-content">
        <div class="tab-pane active" id="block-tab-details" role="tabpanel">
          <div class="row">
            <div class="col-lg-5">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                  <tbody>
                    <tr>
                      <td style="width: 200px;">Software Name</td>
                      <td>{{ $license->name }}</td>
                    </tr>
                    <tr>
                      <td>Manufacturer</td>
                      <td>{{ $license->manufacturer }}</td>
                    </tr>
                    <tr>
                      <td>Type</td>
                      <td>{{ $license->software_type->name }}</td>
                    </tr>
                    <tr>
                      <td>Version</td>
                      <td>{{ $license->version }}</td>
                    </tr>
                    <tr>
                      <td>Vendor</td>
                      <td>{{ $license->vendor }}</td>
                    </tr>
                    <tr>
                      <td>Product Key</td>
                      <td>{{ $license->product_key }}</td>
                    </tr>
                    <tr>
                      <td>Seats</td>
                      <td>{{ $license->seats }}</td>
                    </tr>
                    <tr>
                      <td>License to Name</td>
                      <td>{{ $license->license_name }}</td>
                    </tr>
                    <tr>
                      <td>License to Email</td>
                      <td>{{ $license->license_email }}</td>
                    </tr>
                    <tr>
                      <td>Purchase Date</td>
                      <td>{{ $license->purchase_date }}</td>
                    </tr>
                    <tr>
                      <td>Expiration Date</td>
                      <td>{{ $license->expiration_date }}</td>
                    </tr>
                    <tr>
                      <td>Notes</td>
                      <td>{!! $license->notes !!}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-7">
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
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                  <thead>
                    <tr>
                      <th>Seat</th>
                      <th>Machine Tag</th>
                      <th>Machine Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($installs as $index => $install)
                    <tr>
                      <td>{{ ++$index }}</td>
                      <td>{{ $install->targetable->machine_tag }}</td>
                      <td>{{ $install->targetable->name }}</td>
                      <td>
                        <a class="btn btn-secondary" href="{{ route('licenses.uninstallview', $install->id) }}">Uninstall</a>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="4" class="text-center">No installation</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  function installLicense() {
    window.location.href = "{{ route('licenses.installview',$license->id) }}";
  }

  function editLicense() {
    window.location.href = "{{ route('licenses.edit',$license->id) }}";
  }

  function deleteLicense() {
    $("form#license-delete").submit();
  }

  $(document).ready(function() {
    $("form#license-delete").submit(function(e) {
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
          $("form#license-delete").off("submit").submit();
        } else {
          $('a[href$="#block-tab-details"]').addClass('active');
          $("#delete-license-link").removeClass('active');
        }
      });
    });
  });
</script>
@endpush