@extends('layouts.default');

@section('content')

    <h1>Add / Edit Article</h1>

    <div class="form-group">
        {{ link_to('article', 'Back to List') }}
    </div>

    {{ Form::open([ 'url' => 'article', 'class' => 'form' ]) }}

    {{ Form::hidden('id', $article['id']) }}
    {{ Form::hidden('locationId', isset($article['location']) ? $article['location'][0]['locationId'] : '') }}

    <h3>Where will it appear?</h3>

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

    <h3>What will it say?</h3>

    <hr />

    <div class="form-group">
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', $article['title'], [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('type', 'Article Type:') }}
        {{ Form::select('type', $types, $article['article_type_id'], [ 'class' => 'form-control' ]) }}
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

    <hr />

    <h3>Does this article promote an event ?</h3>

    <div class="form-group">
        {{ Form::select('event', ['Select an Event'] + $events, isset($article['event_id']) ? $article['event_id'] : '', [ 'class' => 'form-control' ]) }}
    </div>

    <hr />

    <h3>Anything Special ?</h3>

    <div class="form-group">
        {{ Form::checkbox('is_featured', 1, $article['is_featured']) }}
        {{ Form::label('is_featured', 'Its a featured article') }}
    </div>

    <div class="form-group">
        {{ Form::checkbox('is_picked', 1, $article['is_picked']) }}
        {{ Form::label('is_picked', 'Its a picked article') }}
    </div>

    <div class="form-group">
        {{ Form::checkbox('is_promo', 1, $article['is_promo']) }}
        {{ Form::label('is_promo', 'Its a promotion article') }}
    </div>

    <h3>Status ?</h3>

    <div class="form-group">
        {{ Form::checkbox('is_active', 1, $article['is_active']) }}
        {{ Form::label('is_active', 'Show the article') }}
    </div>

    <hr />

    <div class="form-group">
        {{ Form::submit('Save Article', [ 'class' => 'btn btn-primary' ]) }}
    </div>

    {{ Form::close() }}

    <div class="form-group">
        {{ link_to('article', 'Back to List') }}
    </div>

@stop
