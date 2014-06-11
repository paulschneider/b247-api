@extends('layouts.default');

@section('content')

<h2>Article List</h2>

<div class="form-group">
    {{ link_to('article/create', 'Create New Article') }}
</div>

<table class="table table-bordered">
  <thead>
      <th></th>
      <th>Title</th>
      <th>Featured</th>
      <th>Picked</th>
      <th>Promo</th>
      <th>Active</th>
      <th>Created</th>
      <th>Edit</th>
  </thead>
  <tbody>
      <?php $i = 1 ?>
      @foreach($articles AS $article)
      <tr>
            <td>{{ $i }}</td>
            <td>{{ $article['title'] }}</td>
            <td>{{ oracle($article['is_featured']) }}</td>
            <td>{{ oracle($article['is_picked']) }}</td>
            <td>{{ oracle($article['is_promo']) }}</td>
            <td>{{ oracle($article['is_active']) }}</td>
            <td>{{ $article['created_at'] }}</td>
            <td>{{ link_to('article/'. $article['id'] .'/edit', 'Click to Edit') }}</td>
      </tr>
      <?php $i++ ?>
      @endforeach
  </tbody>
</table>

@stop
