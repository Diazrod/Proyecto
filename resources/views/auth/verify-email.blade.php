@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('title', 'ParroquiaSMP-VerificarEmail')
@section('auth_header', __('Verify Your Email Address'))

@section('auth_body')
    <div class="text-center">
        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif
        <p>{{ __('If you did not receive the email') }},</p>
        <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Haga clic aqui para solicitar otro') }}
            </button>
        </form>
    </div>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
    </p>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
@stop
