@extends('pages.auth.layout')
@section('title', 'Activation Success')
@section('content')
<H1>Activation Success.</H1>
<br>
<H6>You can login now and be rich!</H6>
<br>

<div class="container-login100-form-btn m-t-17">
    <a href="/auth/login">
        <button class="login100-form-btn backHome">
            Login
        </button>
    </a>
</div>
@stop