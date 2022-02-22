@extends('layouts.dashboard')

@section('title', 'Users')

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
        Users Management
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
          <a class="nav-link active" href="#block-tab-info">Info</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#block-tab-machines">Machines</a>
        </li>
        <li class="nav-item ml-auto">
          <div class="btn-group btn-group-sm pr-2">
            <div class="btn-group btn-group-sm" role="group">
              <button type="button" class="btn btn-primary dropdown-toggle" id="btnGroupTabs1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
              </button>
              <div class="dropdown-menu dropdown-menu-right font-size-sm" aria-labelledby="btnGroupTabs1">
                <a class="dropdown-item" onclick="editUser()" href="#">
                  <i class="fa fa-fw fa-pencil-alt mr-1"></i> Edit User
                </a>
                <a id="delete-user-link" class="dropdown-item" onclick="deleteUser()" href="#">
                  <i class="fa fa-fw fa-trash mr-1"></i> Delete User
                </a>
                {!! Form::open(['class'=>'d-none', 'id' => 'user-delete', 'method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </li>
      </ul>
      <div class="block-content tab-content">
        <div class="tab-pane active" id="block-tab-info" role="tabpanel">
          <div class="row">
            <div class="col-lg-3">
              <div class="text-center">
                @if(is_null($user->getMedia('avatars')->first()))
                <img width="200px" src="{{ asset('media/avatars/avatar0.jpg') }}" class="rounded">
                @else
                <img width="200px" src="{{ $user->getMedia('avatars')->first()->getUrl('thumb') }}" class="rounded mb-2 mb-lg-0">
                @endif
              </div>
            </div>
            <div class="col-lg-9">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                  <tbody>
                    <tr>
                      <td>Name</td>
                      <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                    </tr>
                    <tr>
                      <td>Username</td>
                      <td>{{ $user->username }}</td>
                    </tr>
                    <tr>
                      <td>Email</td>
                      <td>{{ $user->email }}</td>
                    </tr>
                    <tr>
                      <td>Birth Date</td>
                      <td>{{ $user->birth_date }}</td>
                    </tr>
                    <tr>
                      <td>Contact No.</td>
                      <td>{{ $user->contact_no }}</td>
                    </tr>
                    <tr>
                      <td>Employee ID</td>
                      <td>{{ $user->employee_id }}</td>
                    </tr>
                    <tr>
                      <td>Job Title</td>
                      <td>{{ $user->job_title }}</td>
                    </tr>
                    <tr>
                      <td>Location</td>
                      <td>@if($user->location){{ $user->location->name }}@endif</td>
                    </tr>
                    <tr>
                      <td>Roles</td>
                      <td>
                        @if(!empty($user->getRoleNames()))
                        {{ implode(', ', $user->getRoleNames()->toArray()) }}
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td>Notes</td>
                      <td>{!! $user->notes !!}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane" id="block-tab-machines" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered table-striped table-vcenter">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Machine Tag</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @forelse($machines as $index => $machine)
                <tr>
                  <td>{{ ++$index }}</td>
                  <td>{{ $machine->checkable->machine_tag }}</td>
                  <td>{{ $machine->checkable->name }}</td>
                  <td>
                    <a class="btn btn-light" href="{{ route('machines.checkinview',$machine->checkable_id) }}">Checkin</a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center">No machines to show</td>
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
  function editUser() {
    window.location.href = "{{ route('users.edit',$user->id) }}";
  }

  function deleteUser() {
    $("form#user-delete").submit();
  }

  $(document).ready(function() {
    $("form#user-delete").submit(function(e) {
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
          $("form#user-delete").off("submit").submit();
        } else {
          $('a[href$="#block-tab-info"]').addClass('active');
          $("#delete-user-link").removeClass('active');
        }
      });
    });
  });
</script>
@endpush