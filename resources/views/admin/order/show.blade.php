@extends('layouts.base')

@section('content')
<div class="order-wrapper">
    <h1>
        Order detail
    </h1>
    @if ($order->process == 0)
    <a class="process-btn" title="Process" href="{{ route('orders.process.display', ['order' => $order]) }}">
        Process
    </a>
    @elseif($order->process == 1)
    <h4><strong>Accepted</strong></h4>
    @elseif($order->process == 2)
    <h4><strong>Declined</strong></h4>
    @endif
    <div class="order">
        <section class="order__address">
            <div class="address">
                <h3>Order no: {{ $order->id }}</h3>
                <table class="payment-shipping">
                    <tr>
                        <td>
                            Payment:
                        </td>
                        <td>
                            @if ($order->card)
                            By bank card
                            @else
                            Cash
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Shipping:
                        </td>
                        <td>
                            @if ($order->delivery)
                            Delivery
                            @else
                            By handover
                            @endif
                        </td>
                    </tr>
                </table>
                <h3>Delivery address: </h3>
                <table>
                    <tr>
                        <td>
                            Fullname:
                        </td>
                        <td>
                            {{ $order->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>Address:</td>
                        <td>{{ $order->address }}</td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td class="phone">
                            <a href="tel:{{ $order->phone }}">{{ $order->phone }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email:
                        </td>
                        <td>
                            {{ $order->email }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Note:
                        </td>
                        <td>
                            {{ $order->note }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="total">
                <h3>Total Sum: </h3>
                <p>
                    {{ $order->sum }} €
                </p>
                <br />
                <h4>Paid:</h4>
                <p>
                    <strong>{{ ($order->card ? ($order->paid ? 'By card' : 'No') : 'Cash') }}</strong>
                </p>
                @if ($order->delivery)
                <span>(Including delivery ~ 5€)</span>
                @endif
            </div>
        </section>
        <section class="order__items">
            <h3>Ordered items: </h3>
            <table>
                <thead>
                    <tr>
                        <th>
                            Item name
                        </th>
                        <th>
                            Price
                        </th>
                        <th>
                            Count
                        </th>
                        <th>
                            Sum
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->product->name }}
                        </td>
                        <td>
                            {{ $item->product->price }} €
                        </td>
                        <td>
                            {{ $item->count }}
                        </td>
                        <td>
                            {{ $item->sum }} €
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</div>
@endsection
