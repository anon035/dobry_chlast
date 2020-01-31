@extends('layouts.base')

@section('content')

<div class="checkout-result">
    <i class="fas fa-times-circle"></i>
    <h1>Order unsuccessful.</h1>
    <h2>Your order wasn't placed.</h2>

    <p>
        You may want to <a href="#" onclick="tryAgain(event);">pay again</a> or <a href="#"
            onclick="tryAgain(event, true);">change
            order details</a>.
    </p>
</div>
{!! $form !!}
@endsection

@push('scripts')
<script>
    function tryAgain(event, edit = false) {
        event.preventDefault();
        let form;
        if (edit) {
            prepareCheckout();
            form = document.querySelector('form[name="order-checkout"]');
        } else {
            form = document.querySelector('form[name="order-pay"]');
        }
        form.submit();
        }
</script>
@endpush
