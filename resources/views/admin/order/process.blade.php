@extends('layouts.base')

@section('content')
<div class="process-wrapper">

    <h1>Process order #{{ $order->id }}</h1>
    <h3>Customer details: </h3>
    <table class="customer-details">
        <tr>
            <td>Name: </td>
            <td>{{ $order->name }}</td>
        </tr>
        <tr>
            <td>Address: </td>
            <td>{{ $order->address }}</td>
        </tr>
        <tr>
            <td>Email: </td>
            <td>{{ $order->email }}</td>
        </tr>
        <tr>
            <td>Phone: </td>
            <td>{{ $order->phone }}</td>
        </tr>
    </table>
    <h3>Payment details: </h3>
    <table class="customer-details">
        <tr>
            <td>Payment: </td>
            <td>{{ ($order->card ? 'By card' : 'Cash') }}</td>
        </tr>
        <tr>
            <td>Shipping: </td>
            <td>{{ ($order->delivery ? 'Delivery' : 'By handover') }}</td>
        </tr>
        <tr>
            <td>Paid: </td>
            <td>{{ ($order->card ? ($order->paid ? 'By card' : 'No') : 'Cash') }}</td>
        </tr>
    </table>
    <div class="process">
        <section class="process__response">
            @php
            $formAction = route('orders.process', ['order' => $order]);
            @endphp
            <form method="POST" action="{{ $formAction }}">
                @csrf
                <input type="hidden" name="process" value="1">
                <h3>Accept</h3>
                <h5>Response text <i class="fas fa-arrow-down"></i></h5>
                <textarea name="response" id="" cols="30" rows="10">
Your order was accepted.

We've accepted your order and we're getting it ready.
You can see your order in "My account".

Thank you for shopping with us.
(dobry-chlast.sk)
                </textarea>
                <div class="button-wrapper">
                    <button>
                        <i class="fas fa-check"></i> Accept
                    </button>
                </div>
            </form>
            <form method="POST" action="{{ $formAction }}">
                @csrf
                <input type="hidden" name="process" value="2">
                <h3>Decline</h3>
                <h5>Response text <i class="fas fa-arrow-down"></i></h5>
                <textarea name="response" id="" cols="30" rows="10">
We are truly sorry, but your order was declined due to following reasons:


We would like to thank you for visiting our site.
(dobry-chlast.sk)
                </textarea>
                <div class="button-wrapper">
                    <button>
                        <i class="fas fa-times"></i> Decline
                    </button>
                </div>
            </form>
        </section>
        <section class="process__products">
            <h2>Products</h2>
            <table>
                <thead>
                    <tr>
                        <th>
                            Image
                        </th>
                        <th>
                            Product
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
                        @php
                        $product = $item->product;
                        @endphp
                        <td class="product-image">
                            <img src="{{ asset($product->photo_path) }}" alt="">
                        </td>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>
                            {{ $product->price }}
                        </td>
                        <td>
                            {{ $item->count }}
                        </td>
                        <td>
                            {{ $item->sum }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>
</div>
@endsection
