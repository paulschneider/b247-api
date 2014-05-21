@extends('layouts.default');

<div class="col-md-6 col-md-offset-3" style="float : left">

    <h1>Register</h1>

    {{ Form::open([ 'url' => '/register', 'class' => 'form' ]) }}

    <div class="form-group">
        {{ Form::label('first_name', 'Firstname:') }}
        {{ Form::text('Firstname', null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('last_name', 'Lastname:') }}
        {{ Form::text('Lastname', null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::label('email', 'Email:') }}
        {{ Form::text('Email', null, [ 'class' => 'form-control' ]) }}
    </div>

    <div class="form-group">
        {{ Form::submit('Create User', [ 'class' => 'btn btn-primary' ]) }}
    </div>

    {{ Form::close() }}

</div>
