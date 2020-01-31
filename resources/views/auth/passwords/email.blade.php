@extends('layouts.base')

@section('content')
<div class="basic-form">
    <h1><i class='fas fas fa-sync'></i> Reset Password</h1>
    <form method="POST" action="{{ route('register') }}">
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <span data-name="Email">
                <input value="{{ old('email') }}" autocomplete="email" placeholder="Enter you email (* required)"
                    type="text" name="email" id="email" autofocus required>


            </span>


            <div class="submit-wrapper reset-wrapper">
                <button type="submit">
                    Send Password Reset Link <i class="far fa-paper-plane"></i>
                </button>
            </div>
        </form>
</div>
@endsection
