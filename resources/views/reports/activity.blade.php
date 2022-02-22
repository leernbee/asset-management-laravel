@extends('layouts.dashboard')

@section('title', 'Reports')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection

@section('js_after')
<script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
@endsection

@section('hero')
<div class="bg-body-light">
  <div class="content content-full">
    <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
      <h1 class="flex-sm-fill h3 my-2">
        Reports
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
        <h3 class="block-title">Activity Log</h3>
        <div class="block-options">
          <a role="button" class="btn btn-sm btn-primary" href="{{action('ReportController@export')}}">Export</a>
        </div>
      </div>
      <div class="block-content">
        <div class="table-responsive mb-3">
          <table class="table table-bordered data-table">
            <thead>
              <tr>
                <th>Log Date</th>
                <th>Admin</th>
                <th>Action</th>
                <th>Date</th>
                <th>Type</th>
                <th>Item</th>
                <th>Target</th>
                <th>Notes</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">
  $(function() {

    var table = $('.data-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('reports.activityJson') }}",
      columns: [{
          data: 'created_at',
          name: 'created_at'
        },
        {
          data: 'admin',
          name: 'admin'
        },
        {
          data: 'action',
          name: 'action'
        },
        {
          data: 'action_date',
          name: 'action_date'
        },
        {
          data: 'type',
          name: 'type'
        },
        {
          data: 'item',
          name: 'item'
        },
        {
          data: 'target',
          name: 'target'
        },
        {
          data: 'notes',
          name: 'notes'
        }
      ],
      "order": [
        [0, "desc"]
      ]
    });
  });
</script>
@endpush