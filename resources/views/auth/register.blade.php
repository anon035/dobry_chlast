@extends('layouts.base')

@section('content')

<div class="basic-form">
    <h1><i class='fas fa-user-plus'></i> Register</h1>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <span data-name="Fullname">
            <input value="{{ old('name') }}" autocomplete="name" placeholder="Enter you name (optional)" type="text"
                name="name" id="name" autofocus>
        </span>
        <span data-name="Email">
            <input value="{{ old('email') }}" autocomplete="email" placeholder="Enter you name (* required)" type="text"
                name="email" id="email" required>
        </span>
        <span data-name="Password">
            <input value="{{ old('password') }}" autocomplete="password" placeholder="Enter you password (* required)"
                type="password" name="password" id="password" required>
        </span>
        <span data-name="Confirm password">
            <input placeholder="Verify your password (* required)" type="password" name="password_confirmation"
                id="password-confirm" required>
        </span>
        <div class="gdpr-wrapper">
            <label class="gdpr" for="gdpr">
                <p>
                    GDRP consent
                </p>
                <input type="hidden" name="gdpr" value="0">
                <input type="checkbox" name="gdpr" id="gdpr" value="1">
                <span></span>
            </label>
        </div>

        <div class="submit-wrapper">
            <button onclick="validateInput(event)" type="submit">
                Register <i class="far fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
    const validateInput = (e) => {
        const Toast = Swal.mixin({
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 2500
        });

        if(!validatePassword()){
            e.preventDefault();
            Toast.fire({
                type: 'warning',
                title: 'Password need to be at least 8 characters long and contain one uppercase letter'
            });
        }

        const gdpr = document.getElementById("gdpr");

        if(!gdpr.checked){
            e.preventDefault();
            warningTitle = "You must consent with GDPR.";
            Toast.fire({
            type: 'warning',
            title: warningTitle
            });
        }
    }

   const validatePassword = () => {
    const password = document.getElementById("password");
    if((password.value.length > 7) && (password.value.match(/[A-Z]+/))){
        return true;
    } else {
        return false;
    }
   }
</script>
@endpush
