@extends('layouts.default');

@section('content')

<h2>Channel List</h2>

<div class="form-group">
    {{ link_to('channel/create', 'Create New Channel') }}
</div>

<table class="table table-bordered">
  <thead>
      <th></th>
      <th>Name</th>
      <th>Channel</th>
      <th>Status</th>
      <th>Active</th>
      <th>Edit</th>
  </thead>
  <tbody>
      <?php $i = 1 ?>
      @foreach($channels AS $channel)
      <tr>
            <td>{{ $i }}</td>
            <td>{{ $channel->name }}</td>
            <td>{{ getParentChannel($channels, $channel) }}</td>
            <td>{{ oracle($channel->is_active) }}</td>
            <td>{{ $channel->created_at }}</td>
            <td>{{ link_to('channel/edit/'.$channel->id, 'Click to Edit') }}</td>
      </tr>
      <?php $i++ ?>
      @endforeach
  </tbody>
</table>

@stop
