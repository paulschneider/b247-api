@extends('layouts.default');

@section('content')

<h2>Venue List</h2>

<div class="form-group">
    {{ link_to('venue/create', 'Create New Venue') }}
</div>

<table class="table table-bordered">
  <thead>
      <th></th>
      <th>Name</th>
      <th>Created</th>
      <th>Updated</th>
      <th>Active</th>
      <th>Edit</th>
  </thead>
  <tbody>
      <?php $i = 1 ?>

      @if(isset($venues))
          @foreach($venues AS $venue)
          <tr>
                <td>{{ $i }}</td>
                <td>{{ $venue->name }}</td>
                <td>{{ $venue->created_at }}</td>
                <td>{{ $venue->updated_at }}</td>
                <td>{{ oracle($venue->is_active) }}</td>
                <td>{{ link_to('venue/' . $venue->id . '/edit', 'Edit') }}</td>
          </tr>
          <?php $i++ ?>
          @endforeach
      @endif
  </tbody>
</table>

@stop
