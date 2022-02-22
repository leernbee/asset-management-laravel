@extends('layouts.dashboard')

@section('title', 'Machines')

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

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="block">
      <ul class="nav nav-tabs nav-tabs-block align-items-center" data-toggle="tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#block-tab-details">Details</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#block-tab-licenses">Licenses</a>
        </li>
        <li class="nav-item ml-auto">
          <div class="btn-group btn-group-sm pr-2">
            <div class="btn-group btn-group-sm" role="group">
              <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupTabs1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
              </button>
              <div class="dropdown-menu dropdown-menu-right font-size-sm" aria-labelledby="btnGroupTabs1">
                <a class="dropdown-item" onclick="editMachine()" href="#">
                  <i class="fa fa-fw fa-pencil-alt mr-1"></i> Edit Machine
                </a>
                <a id="delete-machine-link" class="dropdown-item" onclick="deleteMachine()" href="#">
                  <i class="fa fa-fw fa-trash mr-1"></i> Delete Machine
                </a>
                {!! Form::open(['class'=>'d-none', 'id' => 'machine-delete', 'method' => 'DELETE','route' => ['machines.destroy', $machine->id],'style'=>'display:inline']) !!}
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
            <div class="col-lg-3">

              <div class="row">
                <div class="col-lg-12 text-center">
                  @if($checkout !== null)
                  <label>Checked Out To</label>
                  <div class="mb-3">
                    @if($checkout->targetable_type == 'App\User')
                    <i class="fa fa-user"></i> {{ $checkout->targetable->first_name }} {{ $checkout->targetable->last_name }}
                    @else
                    <i class="fa fa-map-marker"></i> {{ $checkout->targetable->name }}
                    @endif
                  </div>
                  @endif
                  <div class="text-center">
                    @can('Checkout/Checkin machines')
                    @if (isset($machine->checks()->latest()->first()->action) && $machine->checks()->latest()->first()->action == 'checkout')
                    <a class="btn btn-light" href="{{ route('machines.checkinview',$machine->id) }}">Checkin</a>
                    @else
                    @if($machine->status->type == 'Deployable')
                    <a class="btn btn-secondary" href="{{ route('machines.checkoutview',$machine->id) }}">Checkout</a>
                    @else
                    <a class="btn btn-secondary disabled" href="{{ route('machines.checkoutview',$machine->id) }}">Checkout</a>
                    @endif
                    @endif
                    @endcan
                  </div>
                </div>
              </div>

              <div class="text-center">
                {!! QrCode::size(200)->generate(Request::url()); !!}
              </div>
            </div>
            <div class="col-lg-9">
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
                  <tbody>
                    <tr>
                      <td style="width: 300px;">Machine Tag</td>
                      <td>{{ $machine->machine_tag }}</td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>{{ $machine->status->name }}</td>
                    </tr>
                    <tr>
                      <td>Name</td>
                      <td>{{ $machine->name }}</td>
                    </tr>
                    <tr>
                      <td>Machine Type</td>
                      <td>{{ $machine->machine_type->name }}</td>
                    </tr>
                    <tr>
                      <td>Operating System</td>
                      <td>{{ $machine->operating_system->name }}</td>
                    </tr>
                    <tr>
                      <td>Manufacturer</td>
                      <td>{{ $machine->manufacturer }}</td>
                    </tr>
                    <tr>
                      <td>Model</td>
                      <td>{{ $machine->model }}</td>
                    </tr>
                    <tr>
                      <td>Serial</td>
                      <td>{{ $machine->serial }}</td>
                    </tr>
                    <tr>
                      <td>Support Link</td>
                      <td>{{ $machine->support_link }}</td>
                    </tr>
                    <tr>
                      <td>Active Service Date</td>
                      <td>{{ $machine->service_date }}</td>
                    </tr>
                    <tr>
                      <td>Default Location</td>
                      <td>{{ $machine->location->name }}</td>
                    </tr>
                    <tr>
                      <td>Notes</td>
                      <td>{!! $machine->notes !!}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                  <thead>
                    <tr>
                      <th colspan="2">Additional Fields</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($metas as $key => $meta)
                    <tr>
                      <td style="width: 300px;">{{ $key }}</td>
                      <td>{{ $meta }}</td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="2" class="text-center">No additional fields to show</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

            </div>
          </div>
        </div>
        <div class="tab-pane" id="block-tab-licenses" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Software Name</th>
                  <th>Product Key</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($installs as $index => $install)
                <tr>
                  <td>{{ ++$index }}</td>
                  <td>{{ $install->checkable->name }}</td>
                  <td>{{ $install->checkable->product_key }}</td>
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
@endsection

@push('scripts')
<script>
  function editMachine() {
    window.location.href = "{{ route('machines.edit', $machine->id) }}";
  }

  function deleteMachine() {
    $("form#machine-delete").submit();
  }

  $(document).ready(function() {
    $("form#machine-delete").submit(function(e) {
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
          $("form#machine-delete").off("submit").submit();
        } else {
          $('a[href$="#block-tab-details"]').addClass('active');
          $("#delete-machine-link").removeClass('active');
        }
      });
    });
  });
</script>
@endpush