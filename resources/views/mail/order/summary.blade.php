<div style="max-width: 600px; height: 900px; background: #fff">
    <div style="text-align: center; width: 100%;">
        <img width="200px; margin: auto;" src="{{ asset('images/email_logo.png') }}" alt="Dobry-chlast.sk">
    </div>

    <div style="width: 600px; text-align: center;">
        <div style="margin: 20px auto 30px auto;">
            @if ($admin)
            <h4>New order #{{ $order->id }} was created</h4>
            <a href="{{ route('orders.process.display', ['order' => $order]) }}">
                <button style="background: none; border: 1px solid black; padding: 10px 30px;">
                    Process
                </button>
            </a>
            @else
            <h4>Thank you for your order.</h4>
            @endif
        </div>
        @if ($admin)
        <table>
            <tr>
                <td>Name: </td>
                <td>{{ $order->name }}</td>
            </tr>
            <tr>
                <td>Address: </td>
                <td>{{ $order->address }}</td>
            </tr>
            <tr>
                <td>Phone: </td>
                <td>{{ $order->phone }}</td>
            </tr>
            <tr>
                <td>Email: </td>
                <td>{{ $order->email }}</td>
            </tr>
        </table>
        @else
        <p>
            On the table below you can see recap of your order.
            Once we accept your order, you will recieve an confirmation email and your order will be processed and
            delivered.
        </p>
        @endif
        <table>
            <tr>
                <td>
                    Payment type:
                </td>
                <td>
                    @if ($order->card)
                        By bank card (online in advance)
                        @if ($order->paid)
                        <strong>Already paid</strong>
                        @endif
                    @else
                        By cash
                    @endif
                </td>
            </tr>
            <tr>
                <td>
                    Shipping type:
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
        <h4 style="margin-top: 20px; text-align: left;">
            @if ($admin)
            Ordered items:
            @else
            My order
            @endif
        </h4>
        <table style="margin-top: 10px; width: 100%; text-align: center;">
            <thead>
                <tr>
                    <th style="padding: 5px 10px;background: lightblue;">
                        Product
                    </th>
                    <th style="padding: 5px 10px;background: lightblue;">
                        Price
                    </th>
                    <th style="padding: 5px 10px;background: lightblue;">
                        Count
                    </th>
                    <th style="padding: 5px 10px;background: lightblue;">
                        Sum
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td style="padding: 5px 10px;">{{ $item->product->name }}</td>
                    <td style="padding: 5px 10px;">{{ $item->product->price }}€</td>
                    <td style="padding: 5px 10px;">{{ $item->count }}x</td>
                    <td style="padding: 5px 10px;">{{ $item->sum }}€</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
