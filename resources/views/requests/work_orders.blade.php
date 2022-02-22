@extends('layouts.dashboard')

@section('title', 'Work Orders')

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
        Work Orders
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
        <h3 class="block-title">My Work Orders</h3>
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
                <th style="width:100px;">Actions</th>
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
                <td class="text-center">
                  <a class="btn btn-secondary" href="{{ route('requests.show', $request->id) }}"><i class="fa fa-eye"></i></a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="8" class="text-center">No requests to show</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {!! $requests->links() !!}

      </div>
    </div>
  </div>
</div>
@endsection