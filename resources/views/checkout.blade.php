@extends('layouts.base')

@section('content')
<section class="checkout-wrapper">
    <h1 class="heading">Checkout</h1>
    <div class="checkout">
        <div class="checkout__user">
            <h2>
                Shipping details
            </h2>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="contact-details">
                    <span data-name="Name"><input value="{{ ($user ? $user->name : '') }}" required placeholder="Name"
                            type="text" name="name" id="name"></span>
                    <span data-name="Email"><input value="{{ ($user ? $user->email : '') }}" required
                            placeholder="Email" type="email" name="email" id="email"></span>
                    <span data-name="Address"><input value="{{ ($user ? $user->address : '') }}" required
                            placeholder="Address, City and postal code" type="text" name="address" id="address"></span>
                    <span data-name="Phone"><input value="{{ ($user ? $user->phone : '') }}" required
                            placeholder="Phone Number" type="text" name="phone" id="phone"></span>
                    <span data-name="Note"><input placeholder="Add note" type="text" name="note" id="note"></span>
                </div>
                <div class="gdpr-wrapper">
                    <label class="gdpr" for="gdpr">
                        <input type="hidden" name="gdpr" value="0">
                        <p>GDRP consent</p>
                        <input type="checkbox" {{ ($user && $user->gdpr ? 'checked' : '') }} name="gdpr" id="gdpr"
                            value="1">
                        <span></span>
                    </label>
                </div>
                <h2>
                    Payment Method
                </h2>
                <div class="payment-details">
                    <label for="cash">Cash
                        <input type="radio" name="card" value="0" id="cash">
                        <span></span>
                    </label>
                </div>
                <div class="payment-details">
                    <label for="card">By bank card (online in advance)
                        <input type="radio" name="card" value="1" id="card">
                        <span></span>
                    </label>
                </div>
                @if ($isVip)
                <div class="partial-payment">
                    <span data-name="Partial payment">
                        <input placeholder="Insert the amount you pay" type="text" name="pay_sum"
                            value="{{ number_format($totalSum, 2, '.', '') }}">
                    </span>
                    <small>Insert the price WITHOUT thousands separator (comma) - (i.e. 100 or 1500.50)</small>
                </div>
                @endif
                <h2>
                    Shipping Method
                </h2>
                <div class="shipping-details">
                    <label for="personal">By handover (Free)
                        <input onchange="handleShippingFee(this)" type="radio" name="delivery" value="0" id="personal">
                        <span></span>
                    </label>
                </div>
                <div class="shipping-details">
                    <label for="delivery">Delivery (Payed ~ 5€ fee)
                        <input onchange="handleShippingFee(this)" type="radio" name="delivery" value="1" id="delivery">
                        <span></span>
                    </label>
                </div>
                @foreach ($productCount as $productId => $count)
                <input type="hidden" name="products[{{ $productId }}]" value="{{ $count }}">
                @endforeach
                <div class="submit">
                    <button {{ !$productCount ? 'disabled' : '' }} onclick="checkboxValidation(event)"
                        type="submit">Order
                        &#x2192;</button>
                </div>
            </form>
        </div>
        <div class="checkout__order">
            <h2>
                Your order
            </h2>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Count</th>
                        <th>Sum</th>
                    </tr>
                </thead>
                <tbody id="cart-checkout">
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>
                            {{ $productCount[$product->id] }}
                        </td>
                        <td>
                            {{ number_format($productSum[$product->id], 2, ',', ' ') }}€
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tbody class="sum">
                    <tr>
                        <td colspan="2">Total Sum <small>(Inc. tax)</small>: </td>
                        <td colspan="2" id="cart-sum-2">
                            {{ number_format($totalSum, 2, ',', ' ') }}€
                        </td>
                    </tr>
                    <tr id="shipping-sum"></tr>
                    <tr id="shipping-sum-total"></tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<div id="unavailable-items" style="display:none;">
    <ul>
        @foreach ($notInStock as $product)
        {{ $product->name }} : {{ $productCount[$product->id] }}
        @endforeach
    </ul>
</div>
@endsection

@push('scripts')
<script>
    checkboxValidation = (e) => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 2500
        });

        const cash = document.getElementById("cash");
        const card = document.getElementById("card");

        const personal = document.getElementById("personal");
        const delivery = document.getElementById("delivery");

        const gdpr = document.getElementById("gdpr");
        const gdprContainer = document.querySelector(".gdpr");

        const contactDetailsInputs = document.querySelectorAll(".contact-details input");
        let empty = true;
        if(contactDetailsInputs[0].value.length > 0 && contactDetailsInputs[1].value.length > 0){
            empty = false;
        }

        if(!empty){
            let warningTitle = "";
            if(!cash.checked && !card.checked){
                warningTitle = "You need to select payment method";
                Toast.fire({
                    type: 'warning',
                    title: warningTitle
                });
                e.preventDefault();
            }

            if(!personal.checked && !delivery.checked){
                if(warningTitle.length > 0){
                    warningTitle += " and shipping method";
                } else {
                    warningTitle = "You need to select shipping method";
                }
                Toast.fire({
                type: 'warning',
                title: warningTitle
                });
                e.preventDefault();
            }

            if(!gdpr.checked){

                  gdprContainer.classList.add("requiredCheckbox");
                    setTimeout(() => {
                        gdprContainer.classList.remove("requiredCheckbox");
                    }, 2500);
                warningTitle = "You must consent with GDPR.";
                Toast.fire({
                type: 'warning',
                title: warningTitle
                });
                e.preventDefault();
            }
        }
    }
        @if($notInStock)
        Swal.fire({
            type: 'info',
            title: 'We are truly sorry, but following items are available only in count:',
            html: document.getElementById('unavailable-items').innerHTML
        });
        @endif

        @if($productDeleted)
        Swal.fire({
            type: 'info',
            title: 'productDeleted',
        });
        @endif

        const partialPayment = () => {
            console.log("partial");
        }

        const handleShippingFee = (element) => {
            const totalContainer = document.querySelector(".sum");
            let sum = document.getElementById("shipping-sum");
            let rowTotal = document.getElementById("shipping-sum-total");
            let totalText = document.getElementById("cart-sum-2");
            let originalValue = "";
            totalText = totalText.innerText.replace("€", "");
            if(totalText.includes(",")){
                if(totalText.includes(" ")){
                    totalText = totalText.replace(" ", "");
                }
                originalValue = Number(totalText.replace(",", "."));
            } else {
                originalValue = Number(totalText);
            }

            let shippingFee;
            let shippingPrice;
            // Price from which free shipping is active
            const freeShippingAmount = 99;
            if(element.value == 1){
                // delivery
                if(originalValue > freeShippingAmount){
                    shippingFee = "You have free shipping";
                    shippingPrice = 0;
                } else {
                    shippingFee = "+ 5€"
                    shippingPrice = 5;
                }
            } else {
                // handover
                shippingFee = "Free"
                shippingPrice = 0;
            }

            sum.innerHTML = "";
            rowTotal.innerHTML = "";


            let tdShippingEmpty = document.createElement("td");
            tdShippingEmpty.innerHTML = "Shipping: ";
            let tdShipping = document.createElement("td");
            tdShipping.setAttribute("colspan", "2");
            tdShipping.style.textAlign = "center";
            tdShipping.innerHTML = `${shippingFee} shipping`;

            let tdTotalEmpty = document.createElement("td");
            tdTotalEmpty.innerHTML = "Total: ";
            let tdTotal = document.createElement("td");
            tdTotal.setAttribute("colspan", "2");
            tdTotal.style.textAlign = "center";
            tdTotal.innerHTML = `<small>(inc. shipping)</small> <p class="total-checkout-sum">${originalValue + shippingPrice}€</p>`;
            rowTotal.appendChild(tdTotalEmpty);
            rowTotal.appendChild(tdTotal);

            sum.appendChild(tdShippingEmpty);
            sum.appendChild(tdShipping);
        }


</script>
@endpush
