@extends('layouts.base')

@section('content')
<div class="orders-list">
    <h1>
        Orders list
    </h1>
    <table>
        <thead>
            <tr>
                <th>
                    Order
                </th>
                <th>
                    Name
                </th>
                <th>
                    Address
                </th>
                <th>
                    Products
                </th>
                <th>
                    Total Sum (€)
                </th>
                <th>
                    Paid
                </th>
                <th>
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
            @php
            $href = route('orders.show', ['order'=>$order]);
            @endphp
            <tr>
                <td>
                    <a href="{{ $href }}">
                        {{ $order->id }}
                    </a>
                </td>
                <td>
                    <a href="{{ $href }}">
                        {{ $order->name }}
                    </a>
                </td>
                <td>
                    <a href="{{ $href }}">
                        {{ $order->address }}
                    </a>
                </td>
                <td>
                    <a href="{{ $href }}">
                        {{ $order->product_preview }}
                    </a>
                </td>
                <td>
                    <a href="{{ $href }}">
                        {{ $order->sum }}
                    </a>
                </td>
                <td>
                    <a href="{{ $href }}">
                        {{ ($order->card ? ($order->paid ? 'By card' : 'No') : 'Cash') }}
                        @if ($order->paid)
                        <i aria-label="Paid icon" title="Fully paid" class="fas fa-check"></i>
                        @endif
                    </a>
                </td>
                <td class="cell-action">
                    @if ($order->process == 1)
                    <i title="Order was accepted" class="fas fa-check"></i>
                    @elseif($order->process == 2)
                    <i title="Order was declined" class="fas fa-times"></i>
                    @else
                    <a title="Process" href="{{ route('orders.process.display', ['order' => $order]) }}">
                        <i title="Order awaiting process" alt="Process" class="far fa-question-circle"></i>
                    </a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="6">
                    No orders were created yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    const deleteOrder = (e) => {
       let formId = `delete-form-${e.target.dataset.orderId}`;
       let form = document.getElementById(formId);
       form.submit();
    }

    let message = {{ $message }};
    let text = '';
        if (message == 1) {
            text = 'Order was accepted!';
        } else if(message == 2) {
            text = 'Order was declined!';
        }
        if (text) {
            Swal.mixin({
        toast: true,
        position: 'top',
        showConfirmButton: false,
        timer: 2500
    }).fire({
            type: 'info',
            title: text
        });
        }
</script>
@endpush
