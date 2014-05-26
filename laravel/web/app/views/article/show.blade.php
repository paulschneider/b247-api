@extends('layouts.default');
<div class="col-md-6 col-md-offset-3" style="float : left">
    <h2>Article List</h2>

    <div class="form-group">
        {{ link_to('article', 'Create New Article') }}
    </div>

    <table class="table table-bordered">
      <thead>
          <th></th>
          <th>Title</th>
          <th>Featured</th>
          <th>Picked</th>
          <th>Created</th>
          <th>Edit</th>
      </thead>
      <tbody>
          <?php $i = 1 ?>
          @foreach($articles AS $article)
          <tr>
                <td>{{ $i }}</td>
                <td>{{ $article->title }}</td>
                <td>{{ $article->is_featured }}</td>
                <td>{{ $article->is_picked }}</td>
                <td>{{ $article->created_at }}</td>
                <td>{{ link_to('article/edit/'.$article->id, 'Click to Edit') }}</td>
          </tr>
          <?php $i++ ?>
          @endforeach
      </tbody>
    </table>
</div>
