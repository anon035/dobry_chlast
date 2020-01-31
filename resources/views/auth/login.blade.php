@extends('layouts.base')

@section('content')
<div class="basic-form login-form">
    <h1><i class='fas fa-arrow-right'></i> Login</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <span data-name="Email">
            <input value="{{ old('email') }}" autocomplete="email" placeholder="Enter you email (* required)"
                type="text" name="email" id="email" autofocus>

        </span>
        <span data-name="Password">
            <input value="{{ old('password') }}" autocomplete="current-password"
                placeholder="Enter you password (* required)" type="password" name="password" id="password" required>

        </span>

        <div class="submit-wrapper login-submit">
            @if (Route::has('password.request'))
            <a class="forgot-password" href="{{ route('password.request') }}">
                Forgot Your Password?
            </a>

            <button type="submit">
                Login <i class="far fa-paper-plane"></i>
            </button>
        </div>
        @endif
    </form>
</div>
@endsection
