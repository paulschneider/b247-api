@extends('layouts.default');

@section('content')

<h2>Sponsor List</h2>

<div class="form-group">
    {{ link_to('sponsor/create', 'Create New Sponsor') }}
</div>

<table class="table table-bordered">
  <thead>
      <th></th>
      <th>Name</th>
      <th>Active</th>
      <th>Created</th>
      <th>Edit</th>
  </thead>
  <tbody>
      <?php $i = 1 ?>
      @foreach($sponsors AS $sponsor)
      <tr>
            <td>{{ $i }}</td>
            <td>{{ $sponsor->title }}</td>
            <td>{{ oracle($sponsor->is_active) }}</td>
            <td>{{ $sponsor->created_at }}</td>
            <td>{{ link_to('sponsor/'.$sponsor->id . '/edit', 'Click to Edit') }}</td>
      </tr>
      <?php $i++ ?>
      @endforeach
  </tbody>
</table>

@stop
