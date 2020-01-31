@extends('layouts.base')

@section('content')
<div class="user-detail">
    <section class="detail">
        <h2>
            My informations
        </h2>
        <form action="{{ route('users.profile-update', ['user' => $user]) }}" method="POST">
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
                {{-- <a class="reset" href="#">
                    <button>
                        Reset my password
                    </button>
                </a> --}}
            </div>
        </form>
    </section>
    <section class="orders">
        <h2>
            My orders
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
                        @if (!$order->paid && $order->is_vip)
                        <span
                            onclick="payRest('{{ route('orders.pay', ['order' => $order]) }}', {{ $order->sum - $order->paid_sum }}, '{{ csrf_token() }}')"
                            class="unpaid-vip-order__icon" aria-label="Pay the rest icon" title="Pay the rest">
                            <i class="fas fa-euro-sign"></i>
                        </span>
                        @else
                        {{ ($order->card ? ($order->paid ? 'By card' : 'No') : 'Cash') }}
                        @if ($order->paid)
                        <i class="fas fa-check"></i>
                        @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="empty-order" colspan="4">
                        You haven't order anything yet. <a class="link-special desktop-link"
                            href="{{ route('categories.user-view') }}">Select category</a><a
                            class="link-special mobile-link" href="{{ route('home') }}">Select category</a> and change
                        it!
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
    function payRest(action, remainSum, csrf){
        Swal.fire({
            title: 'Enter amount in €. <br/> You have ' + remainSum + '€ still yet to pay.',
            html: '<form method="POST" id="unpaid-form" class="unpaid-vip-order-form" action="' + action + '"><input type="hidden" name="_token" value="' + csrf + '" /><span><input placeholder="Enter the amount" autocomplete="off" type="text" name="pay_sum" /></span><input type="submit" style="display:none" /></form>',
            showCloseButton: true,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: 'Confirm',
            confirmButtonAriaLabel: 'Proceed to payment gate',
            cancelButtonText: 'Cancel',
            cancelButtonAriaLabel: 'Cancel Payment',
            preConfirm: function(){
                const unpaidForm = document.getElementById("unpaid-form");
                unpaidForm.submit();
            }
        });
    }

</script>
@endpush
