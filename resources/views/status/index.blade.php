@extends('layouts.dashboard')

@section('title', 'Status')

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
        <h3 class="block-title">All Status</h3>
        <div class="block-options">
          <a href="{{ route('status.create') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-fw fa-plus mr-1"></i> Add Status
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

        <div class="table-responsive">
          <table class="table table-bordered table-striped table-vcenter">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th>Name</th>
                <th>Description</th>
                <th class="text-center" style="width: 150px;">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($statuses as $status)
              <tr>
                <th class="text-center" scope="row">{{ ++$i }}</th>
                <td class="font-w600 font-size-sm">
                  {{ $status->name }}

                  @if($status->type == 'Deployable')
                  <span class="badge badge-success">{{ $status->type }}</span>
                  @elseif($status->type == 'Pending')
                  <span class="badge badge-warning">{{ $status->type }}</span>
                  @else
                  <span class="badge badge-danger">{{ $status->type }}</span>
                  @endif

                </td>
                <td>{{ $status->desc }}</td>
                <td class="text-center">
                  <a class="btn btn-warning" href="{{ route('status.edit',$status->id) }}"><i class="fa fa-edit"></i></a>
                  {!! Form::open(['class' => 'status-delete', 'method' => 'DELETE','route' => ['status.destroy', $status->id],'style'=>'display:inline']) !!}
                  {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}
                  {!! Form::close() !!}
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4" class="text-center">No statuses to show</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {!! $statuses->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $("form.status-delete").submit(function(e) {
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