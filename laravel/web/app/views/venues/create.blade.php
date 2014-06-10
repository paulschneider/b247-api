@extends('layouts.default');

@section('content')

<h1>Create/Edit a Venue</h1>

<div class="form-group">
    {{ link_to('venue', 'Back to List') }}
</div>

{{ Form::open([ 'url' => 'venue', 'class' => 'form' ]) }}
    {{ Form::hidden('id', $venue->id) }}

<div class="form-group">
    {{ Form::label('name', 'Name:') }}
    {{ Form::text('name', $venue->name, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('address1', 'Address Line 1:') }}
    {{ Form::text('address1', $venue->address_line_1, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('address2', 'Address Line 2:') }}
    {{ Form::text('address2', $venue->address_line_2, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('address3', 'Address Line 3:') }}
    {{ Form::text('address3', $venue->address_line_3, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('postcode', 'Postcode:') }}
    {{ Form::text('postcode', $venue->postcode, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('email', 'Email:') }}
    {{ Form::text('email', $venue->email, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('facebook', 'Facebook:') }}
    {{ Form::text('facebook', $venue->facebook, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('twitter', 'Twitter:') }}
    {{ Form::text('twitter', $venue->twitter, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('phone', 'phone:') }}
    {{ Form::text('phone', $venue->phone, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('is_active', 'Active:') }}
    {{ Form::checkbox('is_active', 1, $venue->is_active) }}
</div>

<div class="form-group">
    {{ Form::submit('Save Venue', [ 'class' => 'btn btn-primary' ]) }}
</div>

{{ Form::close() }}

<div class="form-group">
    {{ link_to('venue', 'Back to List') }}
</div>

@stop
