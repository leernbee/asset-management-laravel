@extends('layouts.dashboard')

@section('title', 'Requests')

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
        Requests
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
        @can('Administer requests')
        <h3 class="block-title">All Requests</h3>
        @else
        <h3 class="block-title">My Requests</h3>
        @endcan
        <div class="block-options">
          <a href="{{ route('requests.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-fw fa-plus mr-1"></i> Create Request
          </a>
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

        @can('Administer requests')
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-vcenter">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Ticket ID</th>
                <th>Requester</th>
                <th>Title</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Assigned Worker</th>
                <th style="width:200px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($requests as $request)
              <tr>
                <td class="text-center" scope="row">{{ ++$i }}</td>
                <td>{{ $request->ticket_id }}</td>
                <td>@if($request->requester){{ $request->requester->first_name }} {{ $request->requester->last_name }}@endif</td>
                <td>{{ $request->title }}</td>
                <td>{{ $request->priority }}</td>
                <td>
                  @if($request->status == 'Rejected' || $request->status == 'Pending'){{ $request->status }}@else{{ $request->work_status }}@endif
                </td>
                <td>@if($request->worker){{ $request->worker->first_name }} {{ $request->worker->last_name }}@endif</td>
                <td class="text-center">
                  <a class="btn btn-secondary" href="{{ route('requests.show', $request->id) }}"><i class="fa fa-eye"></i></a>

                  @if($request->status == 'Rejected')
                  <a class="btn btn-warning disabled" href="{{ route('requests.edit', $request->id) }}"><i class="fa fa-edit"></i></a>
                  @else
                  <a class="btn btn-warning" href="{{ route('requests.edit', $request->id) }}"><i class="fa fa-edit"></i></a>
                  @endif
                  {!! Form::open(['class' => 'request-delete', 'method' => 'DELETE','route' => ['requests.destroy', $request->id],'style'=>'display:inline']) !!}
                  {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}
                  {!! Form::close() !!}
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="9" class="text-center">No requests to show</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {!! $requests->links() !!}
        @else
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-vcenter">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Ticket ID</th>
                <th>Title</th>
                <th>Priority</th>
                <th>Status</th>
                <th style="width:100px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($requests as $request)
              <tr>
                <td class="text-center" scope="row">{{ ++$i }}</td>
                <td>{{ $request->ticket_id }}</td>
                <td>{{ $request->title }}</td>
                <td>{{ $request->priority }}</td>
                <td>@if($request->work_status){{ $request->work_status }}@else{{ $request->status }}@endif</td>
                <td class="text-center"><a class="btn btn-secondary" href="{{ route('requests.show',$request->id) }}"><i class="fa fa-eye"></i></a></td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center">No requests to show</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {!! $requests->links() !!}
        @endcan
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $("form.request-delete").submit(function(e) {
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