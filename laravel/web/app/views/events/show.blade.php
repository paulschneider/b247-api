@extends('layouts.default');

@section('content')

<h2>Events List</h2>

<div class="form-group">
    {{ link_to('event/create', 'Create New Event') }}
</div>

<table class="table table-bordered">
  <thead>
      <th></th>
      <th>Name</th>
      <th>Venue</th>
      <th>Date</th>
      <th>Time</th>
      <th>Active</th>
      <th>Edit</th>
  </thead>
  <tbody>
      <?php $i = 1 ?>

      @if(isset($events))
          @foreach($events AS $event)
          <tr>
                <td>{{ $i }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ $event->venue->name }}</td>
                <td>{{ $event->show_date }}</td>
                <td>{{ short_time($event->show_time) }}</td>
                <td>{{ oracle($event->is_active) }}</td>
                <td>{{ link_to('event/' . $event->id  . '/edit', 'Edit') }}</td>
          </tr>
          <?php $i++ ?>
          @endforeach
      @endif
  </tbody>
</table>

@stop
