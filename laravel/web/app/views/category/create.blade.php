@extends('layouts.default');

@section('content')

<h1>Create/Edit a Category</h1>

<div class="form-group">
    {{ link_to('category/list', 'Back to List') }}
</div>

{{ Form::open([ 'url' => 'category', 'class' => 'form' ]) }}
    {{ Form::hidden('id', $category->id) }}

<div class="form-group">
    {{ Form::label('name', 'Name:') }}
    {{ Form::text('name', $category->name, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('is_active', 'Active:') }}
    {{ Form::checkbox('is_active', 1, $category->is_active) }}
</div>

<div class="form-group">
    {{ Form::submit('Save Category', [ 'class' => 'btn btn-primary' ]) }}
</div>

{{ Form::close() }}

<div class="form-group">
    {{ link_to('category/list', 'Back to List') }}
</div>

@stop
