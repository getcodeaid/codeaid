@extends('emails._action')

@section('message')
            We received a request for a password reset at CodeAid.
            <br>
            If you did not request this, you can safely delete this email
@stop

@section('button_link')
    {{ url('password/reset/'.$token) }}
@stop

@section('button_text')
    Reset Password
@stop