<table>
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
    @forelse ($checks as $key => $log)
    <tr>
      <td>{{ $log->created_at }}</td>
      <td>{{ $log->user->username }}</td>
      <td>{{ $log->action }}</td>
      <td>{{ $log->action_date->format('Y-m-d') }}</td>
      <td>{{ substr($log->checkable_type,4) }}</td>
      <td>{{ $log->checkable->name }}</td>
      <td>
        @if ($log->targetable_type == 'App\User')
        {{ $log->targetable->first_name }} {{ $log->targetable->last_name }}
        @endif

        @if ($log->targetable_type == 'App\Location')
        {{ $log->targetable->name }}
        @endif

        @if ($log->targetable_type == 'App\Machine')
        {{ $log->targetable->name }}
        @endif
      </td>
      <td>{{ $log->notes }}</td>
    </tr>
    @endforeach
  </tbody>
</table>