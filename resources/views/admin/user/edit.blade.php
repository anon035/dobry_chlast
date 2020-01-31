@extends('layouts.base')

@section('content')
<div class="user-detail">
    <section class="detail">
        <h2>
            User informations
        </h2>
        <form action="{{ route('users.update', ['user' => $user]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="informations">
                <span data-name="Name">
                    <input value="{{ $user->name ? $user->name : '' }}" placeholder="Enter name" type="text"
                        name="name"></span>
                <span data-name="Address">
                    <input value="{{ $user->address ? $user->address : '' }}" placeholder="Enter delivery address"
                        type="text" name="address">
                </span>
            </div>
            <div class="informations">
                <span data-name="Phone"><input value="{{ $user->phone ? $user->phone : '' }}"
                        placeholder="Enter phone number" type="text" name="phone"></span>
                <span data-name="Email"><input value="{{ $user->email ? $user->email : '' }}"
                        placeholder="Enter email address" type="text" name="email"></span>
            </div>
            <label class="gdpr" for="gdpr">
                @if ($user->gdpr)
                <p>GDRP consent given</p>
                @else
                <p>GDPR consent NOT given</p>
                @endif
                <input type="checkbox" {{ $user->gdpr ? 'checked' : '' }} name="gdpr" id="gdpr">
                <span></span>
            </label>
            <div class="buttons">
                <button class="submit" type="submit">Save</button>
            </div>
        </form>
    </section>
    <section class="orders">
        <h2>
            User orders
        </h2>
        <table>
            <thead>
                <tr>
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
                        Paid / Total Sum (€)
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
                @forelse ($user->orders as $order)
                <tr {!! !$order->paid && $order->is_vip ? 'class="unpaid-vip-order"' : '' !!}>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $order->address }}
                    </td>
                    <td>
                        @foreach ($order->items as $item)
                        @if ($item->product)
                        <p>{{ $item->product->name }} ({{ $item->count }} x {{ $item->product->price }})</p>
                        @endif
                        @endforeach
                    </td>
                    <td>
                        {{ number_format($order->paid_sum, 2, '.', ',') }} / {{ $order->sum }}
                    </td>
                    <td>
                        <strong>{{ ($order->card ? ($order->paid ? 'By card' : 'No') : 'Cash') }}</strong>
                    </td>
                    <td>
                        <span title="Delete" alt="Delete button" onclick="deleteOrder({{ $order->id }})"
                            class="delete-button edit-btn">✖</span>
                        <form style="display:none;" method="POST" id="delete-form-{{ $order->id }}"
                            action="{{ route('orders.destroy', ['order' => $order]) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="empty-order" colspan="4">
                        No orders yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </section>
</div>
@endsection

@push('scripts')
<script>
    const deleteOrder = (id) => {
        Swal.fire({
            title: 'Delete order?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.value) {
                    document.getElementById('delete-form-' + id).submit();
                }
        })
    }
</script>
@endpush
