@extends('layouts.default');

@section('content')

<h2>Category List</h2>

<div class="form-group">
    {{ link_to('category/create', 'Create New Category') }}
</div>

<table class="table table-bordered">
  <thead>
      <th></th>
      <th>Name</th>
      <th>Status</th>
      <th>Active</th>
      <th>Edit</th>
  </thead>
  <tbody>
      <?php $i = 1 ?>
      @foreach($categories AS $category)
      <tr>
            <td>{{ $i }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ oracle($category->is_active) }}</td>
            <td>{{ $category->created_at }}</td>
            <td>{{ link_to('category/edit/'.$category->id, 'Click to Edit') }}</td>
      </tr>
      <?php $i++ ?>
      @endforeach
  </tbody>
</table>

@stop
