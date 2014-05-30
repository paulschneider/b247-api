@extends('layouts.default');

@section('content')

    <h1>Add / Edit Article</h1>

    <div class="form-group">
        {{ link_to('article', 'Back to List') }}
    </div>

    {{ Form::open([ 'url' => 'article', 'class' => 'form' ]) }}

        {{ Form::hidden('id', $article['id']) }}
        {{ Form::hidden('locationId', isset($article['location']) ? $article['location'][0]['locationId'] : '') }}

    <h2 style="font-size:16px">Where will it appear?</h2>

    <hr />

    <div class="form-group">
        {{ Form::label('Channel', 'channel:') }}
        {{ Form::select('channel', $channels, isset($article['location']) ? $article['location'][0]['channelId'] : '', [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('subChannel', 'Sub-Channel:') }}
        {{ Form::select('subChannel', $subChannels, isset($article['location']) ? $article['location'][0]['subChannelId'] : '', [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('category', 'Category:') }}
        {{ Form::select('category', $categories, isset($article['location']) ? $article['location'][0]['categoryId'] : '', [ 'class' => 'form-control' ]) }}
    </div>

    <h2 style="font-size:16px">What will it say?</h2>

    <hr />

    <div class="form-group">
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', $article['title'], [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('sub_heading', 'Sub Heading:') }}
        {{ Form::text('sub_heading', $article['sub_heading'], [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('body', 'Body:') }}
        {{ Form::textarea('body', $article['body'], [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('postcode', 'Postcode:') }}
        {{ Form::text('postcode', $article['postcode'], [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('is_active', 'Active:') }}
        {{ Form::checkbox('is_active', 1, $article['is_active']) }}
    </div>

    <div class="form-group">
        {{ Form::label('is_featured', 'Featured:') }}
        {{ Form::checkbox('is_featured', 1, $article['is_featured']) }}
    </div>

    <div class="form-group">
        {{ Form::label('is_picked', 'Picked:') }}
        {{ Form::checkbox('is_picked', 1, $article['is_picked']) }}
    </div>

    <div class="form-group">
        {{ Form::submit('Save Article', [ 'class' => 'btn btn-primary' ]) }}
    </div>

    {{ Form::close() }}

    <div class="form-group">
        {{ link_to('article', 'Back to List') }}
    </div>

@stop
