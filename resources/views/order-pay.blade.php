@extends('layouts.base')

@section('content')

<div class="pay-form">
    @if (isset($alreadyPaid) && $alreadyPaid)
    <h1>
        Order has been already paid!
    </h1>
    @else
    @if (isset($sumTooHigh) && $sumTooHigh)
    <h1>
        The amount you've entered is higher than the amount you have left to pay.
        <a href="#" onclick="window.history.back()">Please change the amount and try it again.</a>
    </h1>
    @else

    <h1>
        You will be redirected in 3 seconds to the payment gateway.
    </h1>
    <h4>
        If you won't be redirected, please click on the button below.
    </h4>
    {!! $form ? $form : '' !!}

    @endif
    @endif
</div>

@endsection

@push('scripts')
<script>
    setTimeout(function () {
            form = document.querySelector('form[name="order-pay"]');
            form.submit();
        }, 3 * 1000);
</script>
@endpush
