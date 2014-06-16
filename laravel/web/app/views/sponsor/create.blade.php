@extends('layouts.default');

@section('content')

<h1>Create / Edit Sponsor</h1>

<div class="form-group">
    {{ link_to('sponsor', 'Back to List') }}
</div>

{{ Form::open([ 'url' => 'sponsor', 'class' => 'form' ]) }}
    {{ Form::hidden('id', $sponsor->id) }}

<div class="form-group">
    {{ Form::label('title', 'Title:') }}
    {{ Form::text('title', $sponsor->title, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('url', 'URL:') }}
    {{ Form::text('url', $sponsor->url, [ 'class' => 'form-control' ]) }}
</div>

<hr />

<h3>How will it appear?</h3>

<div class="form-group">
    {{ Form::label('display_style', 'Display Style:') }}
    {{ Form::select('display_style', $displayStyles, $sponsor['display_style'], [ 'class' => 'form-control' ]) }}
</div>

<hr />

<div class="form-group">
    {{ Form::label('is_active', 'Active:') }}
    {{ Form::checkbox('is_active', 1, $sponsor->is_active) }}
</div>

<div class="form-group">
    {{ Form::submit('Save Sponsor', [ 'class' => 'btn btn-primary' ]) }}
</div>

{{ Form::close() }}

<div class="form-group">
    {{ link_to('sponsor', 'Back to List') }}
</div>

@stop
