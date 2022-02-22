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
        <h3 class="block-title">Manage Machines</h3>
        <div class="block-options">
          @can('Create machines')
          <a href="{{ route('machines.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-fw fa-plus mr-1"></i> Add Machine
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
            {!! Form::select('status',$statusList,$status,['class'=>'form-control','onChange'=>'form.submit()']) !!}
          </div>
          <div class="ml-auto col-md-5 col-lg-4 form-group">
            <div class="input-group">
              <input type="text" class="form-control" id="search" name="search" placeholder="Search Machine Tag, Name or Serial" value="{{ request('search') }}">
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
                <th>Machine Tag</th>
                <th>
                  <a href="{{url('machines')}}?search={{request('search')}}&status={{request('status')}}&field=name&sort={{request('sort','asc')=='asc'?'desc':'asc'}}">
                    Name
                  </a>
                  {{request('field')=='name'?(request('sort','asc')=='asc'?'▴':'▾'):''}}
                </th>
                <th>Type</th>
                <th>Operating System</th>
                <th>Status</th>
                <th>Active Service Date</th>
                <th class="text-center" style="width: 250px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($data as $key => $machine)
              <tr>
                <td class="text-center" scope="row">{{ ++$i }}</td>
                <td>{{ $machine->machine_tag }}</td>
                <td class="font-w600 font-size-sm">
                  <a href="{{ route('machines.show',$machine->id) }}">{{ $machine->name }}</a>
                </td>
                <td>{{ $machine->machine_type->name }}</td>
                <td>{{ $machine->operating_system->name }}</td>
                <td>{{ $machine->status->name }}
                  @if($machine->status->type == 'Deployable')
                  <span class="badge badge-success">{{ $machine->status->type }}</span>
                  @elseif($machine->status->type == 'Pending')
                  <span class="badge badge-warning">{{ $machine->status->type }}</span>
                  @else
                  <span class="badge badge-danger">{{ $machine->status->type }}</span>
                  @endif
                </td>
                <td>{{ $machine->service_date }}</td>
                <td class="text-center">
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
                  @can('Edit machines')
                  <a class="btn btn-warning" href="{{ route('machines.edit',$machine->id) }}"><i class="fa fa-edit"></i></a>
                  @endcan
                  @can('Delete machines')
                  {!! Form::open(['class' => 'machine-delete', 'method' => 'DELETE','route' => ['machines.destroy', $machine->id],'style'=>'display:inline']) !!}
                  {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] )  }}
                  {!! Form::close() !!}
                  @endcan
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center">No machines to show</td>
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

@can('Delete machines')
@push('scripts')
<script>
  $(document).ready(function() {
    $("form.machine-delete").submit(function(e) {
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