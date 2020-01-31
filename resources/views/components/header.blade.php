<header class="header">
    @include('components.navigation')
    <div class="logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/header_logo.png') }}"
                alt="Dobry-chlast.sk | Best online shop for alcohol and drinks">
        </a>
    </div>
    <div class="cart" data-cartitems="0">
        <input onchange="closeContainer(this)" type="checkbox" id="cart">
        <label for="cart">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 489 489">
                <path
                    d="M440.1 422.7l-28-315.3c-.6-7-6.5-12.3-13.4-12.3h-57.6C340.3 42.5 297.3 0 244.5 0s-95.8 42.5-96.6 95.1H90.3c-7 0-12.8 5.3-13.4 12.3l-28 315.3c0 .4-.1.8-.1 1.2 0 35.9 32.9 65.1 73.4 65.1h244.6c40.5 0 73.4-29.2 73.4-65.1 0-.4 0-.8-.1-1.2zM244.5 27c37.9 0 68.8 30.4 69.6 68.1H174.9c.8-37.7 31.7-68.1 69.6-68.1zm122.3 435H122.2c-25.4 0-46-16.8-46.4-37.5l26.8-302.3h45.2v41c0 7.5 6 13.5 13.5 13.5s13.5-6 13.5-13.5v-41h139.3v41c0 7.5 6 13.5 13.5 13.5s13.5-6 13.5-13.5v-41h45.2l26.9 302.3c-.4 20.7-21.1 37.5-46.4 37.5z" />
            </svg>
        </label>
        <div class="cart__opencart">
            <table class="items-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Count</th>
                        <th>Sum</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    <tr>
                        <td colspan="4">
                            You cart is empty. Just <a class="link-special desktop-link"
                                href="{{ route('categories.user-view') }}">select category</a><a
                                class="link-special mobile-link" href="{{ route('home') }}">select category</a> and
                            start
                            SHOPPING !
                        </td>
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td></td>
                        <td class="total-sum-text">Total sum: </td>
                        <td class="total-sum-cart">
                            <span id="cart-sum"></span>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
                <tbody>
                    <tr id="items" data-permanent="1">
                        <td colspan="4">
                            <button class="cart-action" onclick="window.cartObj.clear()" id="clear-cart">clear cart
                                &#x2717;</button>
                            <form action="{{ route('orders.create') }}" method="POST"
                                onsubmit="submitCheckout(event, this)" name="order-checkout">
                                @csrf
                                <fieldset id="cart-fields"></fieldset>
                                <button type="submit" class="cart-action">checkout <span
                                        class="cart-checkout-btn">&#x2714;</span></button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</header>

@push('scripts')
<script>
    submitCheckout = (event, form) => {
        event.preventDefault();
        prepareCheckout();
        form.submit();
    }

    prepareCheckout = () => {
        let cartFieldset = document.getElementById('cart-fields');
        let items = window.cartObj.items;
        let vip = window.cartObj.isVip();
        if (vip) {
            cartFieldset.innerHTML += `
            <input type="hidden" name="vip" value="1" />
            `;
        } else {
            cartFieldset.innerHTML += `
            <input type="hidden" name="vip" value="0" />
            `;
        }
        for (let itemId in items){
            cartFieldset.innerHTML += `
                <input type="hidden" name="products[${itemId}]" value="${items[itemId].count}" />
            `;
        }
    }

    // handle menu and cart checked state, when menu opens cart closes etc...
         const burger = document.getElementById("burger");
        const cart = document.getElementById("cart");
        const closeContainer = (e) => {
            if (e === burger && cart.checked) {
                cart.checked = false;
            } else if (e === cart && burger.checked) {
                burger.checked = false;
            }
        }

        document.addEventListener("click", (e) => {
            const header = document.querySelector(".header");
            if (!header.contains(e.target)) {
                if (!e.target.classList.contains("cart-delete-button") && !e.target.classList.contains("regulate-button")) {
                    if (cart.checked) cart.checked = false;
                    if (burger.checked) burger.checked = false;
                }
            }
        });
</script>
@endpush
@prepend('scripts')
<script>
    const cartModule = "{{ asset('/js/Cart.js') }}";
    // import Cart from "{{ asset('./js/Cart.js') }}";

    import(cartModule).then((module) => {
        window.cartObj = new module.default(
            document.getElementById('cart-body'),
            document.getElementById('cart-sum'),
            document.getElementById('cart')
        );
        window.cartObj.load();
    });
</script>
@endprepend
