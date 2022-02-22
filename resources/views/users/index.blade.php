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
<div class="block">
  <div class="block-header">
    <h3 class="block-title">Manage Users</h3>
    <div class="block-options">
      <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">
        <i class="fa fa-fw fa-plus mr-1"></i> Create User
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

    {!! Form::open(['method'=>'get']) !!}
    <div class="row">
      <div class="col-md-4 col-lg-3 form-group">
        {!! Form::select('role',$roleList,$role,['class'=>'form-control','onChange'=>'form.submit()']) !!}
      </div>
      <div class="ml-auto col-md-5 col-lg-4 form-group">
        <div class="input-group">
          <input type="text" class="form-control" id="search" name="search" placeholder="Search Name or Email" value="{{ request('search') }}">
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
            <th class="text-center" style="width: 100px;">
              <i class="far fa-user"></i>
            </th>
            <th>Employee ID</th>
            <th>
              <a href="{{url('users')}}?search={{request('search')}}&role={{request('role')}}&field=name&sort={{request('sort','asc')=='asc'?'desc':'asc'}}">
                Name
              </a>
              {{request('field')=='name'?(request('sort','asc')=='asc'?'▴':'▾'):''}}
            </th>
            <th>
              <a href="{{url('users')}}?search={{request('search')}}&role={{request('role')}}&field=email&sort={{request('sort','asc')=='asc'?'desc':'asc'}}">
                Email
              </a>
              {{request('field')=='email'?(request('sort','asc')=='asc'?'▴':'▾'):''}}
            </th>
            <th>Roles</th>
            <th class="text-center" style="width: 150px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($data as $key => $user)
          <tr>
            <td class="text-center">
              @if(is_null($user->getMedia('avatars')->first()))
              <img src="{{ asset('media/avatars/avatar0.jpg') }}" class="img-avatar img-avatar48">
              @else
              <img src="{{ Auth::user()->getMedia('avatars')->first()->getUrl('thumb') }}" class="img-avatar img-avatar48">
              @endif
            </td>
            <td>{{ $user->employee_id }}</td>
            <td class="font-w600 font-size-sm">
              <a href="{{ route('users.show',$user->id) }}">{{ $user->first_name }} {{ $user->last_name }}</a>
            </td>
            <td>{{ $user->email }}</td>
            <td>
              @if(!empty($user->getRoleNames()))
              {{ implode(', ', $user->getRoleNames()->toArray()) }}
              @endif
            </td>
            <td class="text-center">
              <a class="btn btn-warning" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-edit"></i></a>
              {!! Form::open(['class' => 'user-delete', 'method' => 'DELETE','route' => ['users.destroy', $user->id], 'style'=>'display:inline']) !!}
              {!! Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}
              {!! Form::close() !!}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center">No users to show</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    {!! $data->links() !!}
  </div>
</div>
@endsection

@push('scripts')
<script>
  $(document).ready(function() {
    $("form.user-delete").submit(function(e) {
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