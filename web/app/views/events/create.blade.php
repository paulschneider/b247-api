@extends('layouts.default');

@section('content')

<h1>Create/Edit an Event</h1>

<div class="form-group">
    {{ link_to('event', 'Back to List') }}
</div>

{{ Form::open([ 'url' => 'event', 'class' => 'form' ]) }}
    {{ Form::hidden('id', $event->id) }}

<div class="form-group">
    {{ Form::label('title', 'Title:') }}
    {{ Form::text('title', $event->title, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('venue', 'Venue:') }}
    {{ Form::select('venue', $venues, $event->venue_id, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('date', 'Date:') }}
    {{ Form::text('date', $event->show_date, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('time', 'Time:') }}
    {{ Form::text('time', $event->show_time, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('price', 'Price:') }}
    {{ Form::text('price', number_format($event->price, 2), [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('url', 'URL:') }}
    {{ Form::text('url', $event->url, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('is_active', 'Active:') }}
    {{ Form::checkbox('is_active', 1, $event->is_active) }}
</div>

<div class="form-group">
    {{ Form::submit('Save Event', [ 'class' => 'btn btn-primary' ]) }}
</div>

{{ Form::close() }}

<div class="form-group">
    {{ link_to('event', 'Back to List') }}
</div>

@stop
