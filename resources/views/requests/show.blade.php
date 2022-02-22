@extends('layouts.dashboard')

@section('title', 'Requests')

@section('css_before')
<link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
<style>
  .chat {
    list-style: none;
    margin: 0;
    padding: 0;
  }

  .chat li {
    margin-bottom: 10px;
    padding-bottom: 5px;
    border-bottom: 1px dotted #B3A9A9;
  }

  .chat li .chat-body p {
    margin: 0;
    color: #777777;
  }

  .chat-content {
    overflow-y: scroll;
    height: 350px;
  }
</style>
@endsection

@section('js_before')
<script src="{{ asset('js/app.js') }}"></script>
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
        @if(Auth::user()->id !== $userRequest->worker_id)
        Requests
        @else
        Work Order
        @endif
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
      </ul>
      <div class="block-content tab-content">
        <div class="tab-pane active" id="block-tab-details" role="tabpanel">
          <div class="row">
            <div class="col-lg-5">
              <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                  <tbody>
                    <tr>
                      <td>Ticket ID</td>
                      <td>{{ $userRequest->ticket_id }}</td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      @if(Auth::user()->id !== $userRequest->worker_id)
                      <td>
                        @if($userRequest->status == 'Rejected' || $userRequest->status == 'Pending'){{ $userRequest->status }}@else{{ $userRequest->work_status }}@endif
                      </td>
                      @else
                      <td>
                        <select id="status" class="form-control form-control-alt">
                          <option value="Open" @if($userRequest->work_status == 'Open') selected @endif>Open</option>
                          <option value="In Progress" @if($userRequest->work_status == 'In Progress') selected @endif>In Progress</option>
                          <option value="On Hold" @if($userRequest->work_status == 'On Hold') selected @endif>On Hold</option>
                          <option value="Complete" @if($userRequest->work_status == 'Complete') selected @endif>Complete</option>
                        </select>
                      </td>
                      @endif
                    </tr>
                    <tr>
                      <td>Request Title</td>
                      <td>{{ $userRequest->title }}</td>
                    </tr>
                    <tr>
                      <td>Description</td>
                      <td>{!! $userRequest->description !!}</td>
                    </tr>
                    <tr>
                      <td>Priority</td>
                      <td>{{ $userRequest->priority }}</td>
                    </tr>
                    @if(Auth::user()->id !== $userRequest->worker_id)
                    <tr>
                      <td>Assigned Worker</td>
                      <td>@if($userRequest->worker){{ $userRequest->worker->first_name }} {{ $userRequest->worker->last_name }}@endif</td>
                    </tr>
                    @endif

                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-lg-7">
              <div id="app">
                <input type="hidden" id="request-id" value="{{$userRequest->id}}">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="block block-bordered">
                      <div class="block-header block-header-default">
                        <h3 class="block-title">Chats</h3>
                      </div>
                      <div class="block-content chat-content">
                        <chat-messages :messages="messages"></chat-messages>
                      </div>
                      <div class="block-content pb-3">
                        <chat-form v-on:messagesent="addMessage" :user="{{ Auth::user() }}"></chat-form>
                      </div>
                    </div>
                  </div>
                </div>
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
  $(function() {
    $("#status").change(function() {
      var newStatus = this.value;

      $.ajax({
        url: "{{ route('workOrder.update') }}",
        method: "POST",
        data: {
          "_token": "{{ csrf_token() }}",
          request_id: "{{ $userRequest->id }}",
          status: newStatus
        },
        success: function(response) {
          jQuery(function() {
            One.helpers('notify', {
              type: 'success',
              icon: 'fa fa-check mr-1',
              message: response.success
            });
          });
        },
        error: function() {
          alert("error");
        }
      });
    });
  });
</script>
@endpush