@extends('layouts.default');

@section('content')

<h1>Create a new channel</h1>

<div class="form-group">
    {{ link_to('channel', 'Back to List') }}
</div>

{{ Form::open([ 'url' => 'channel', 'class' => 'form' ]) }}
    {{ Form::hidden('id', $channel->id) }}

<div class="form-group">
    {{ Form::label('name', 'Name:') }}
    {{ Form::text('name', $channel->name, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('parent_channel', 'Parent Channel:') }}
    {{ Form::select('parent_channel', array(0 => "None") + $channels, $channel->parent_channel, [ 'class' => 'form-control' ]) }}
</div>

<div class="form-group">
    {{ Form::label('colour', 'Colour:') }}
    {{ Form::text('colour', $channel->colour, [ 'class' => 'form-control' ]) }}
</div>

@if ( !empty($channel->parent_channel) )

    <hr />

    <h2 style="font-size:16px">Select the categories to display for this channel</h2>

        <div class="rows" style="padding-left:140px; padding-right: 15px; padding-top: 15px">
            <?php $i = 0 ?>
            <div class="row" style="width: 100%; clear: both; margin-bottom:10px">
            @foreach($categories AS $category)
                <div class="item" style="width:170px; float:left">
                    {{ Form::checkbox('category[]', $category->id, in_array($category->id, $channelCategory) ) }}
                    {{ Form::label('colour', $category->name.':') }}
                </div>
                <?php
                    $i++;
                    if( $i == 3 ) :
                ?>
            </div><div class="row" style="width: 100%; clear: both; margin-bottom:10px">
                <?php
                    $i = 0;
                endif;
                ?>
            @endforeach
            </div>
        </div>
    <hr />
@endif

<div class="form-group">
    {{ Form::label('is_active', 'Active:') }}
    {{ Form::checkbox('is_active', 1, $channel->is_active) }}
</div>


<div class="form-group">
    {{ Form::submit('Save Channel', [ 'class' => 'btn btn-primary' ]) }}
</div>

{{ Form::close() }}

<div class="form-group">
    {{ link_to('channel', 'Back to List') }}
</div>

@stop
