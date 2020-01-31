@extends('layouts.base')
@section('content')


<div class="checkout-result">
    <i class="fas fa-check"></i>
    <h1>Thank you for purchasing.</h1>
    <h2>Your order has been placed</h2>

    <p>
        Order summary was sent to your email address. <br>
        You will be notified about order proccess.
    </p>

    <p>
        Thank you for shopping with us! <br />
        We hope you will come back soon.
    </p>
</div>


@endsection

@push('scripts')
<script>
    setTimeout(() => {
            window.cartObj.clear();
        }, 300);
</script>
@endpush