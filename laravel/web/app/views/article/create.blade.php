@extends('layouts.default');

<div class="col-md-6 col-md-offset-3" style="float : left">

    <h1>Create New Article</h1>

    {{ Form::open([ 'url' => 'article', 'class' => 'form' ]) }}

    <h2 style="font-size:14px">Where will it appear?</h2>

    <div class="form-group">
        {{ Form::label('Channel', 'channel:') }}
        {{ Form::select('channel', $channels, null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('subChannel', 'Sub-Channel:') }}
        {{ Form::select('subChannel', $subChannels, null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('category', 'Category:') }}
        {{ Form::select('category', $categories, null, [ 'class' => 'form-control' ]) }}
    </div>

    <h2 style="font-size:14px">What will it say?</h2>

    <div class="form-group">
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('sub_heading', 'Sub Heading:') }}
        {{ Form::text('sub_heading', null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('body', 'Body:') }}
        {{ Form::textarea('body', null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('postcode', 'Postcode:') }}
        {{ Form::text('postcode', null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('is_active', 'Active:') }}
        {{ Form::checkbox('is_active', 1, true) }}
    </div>



    <div class="form-group">
        {{ Form::submit('Create Article', [ 'class' => 'btn btn-primary' ]) }}
    </div>

    {{ Form::close() }}

</div>
