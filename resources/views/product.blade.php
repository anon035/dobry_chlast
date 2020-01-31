@extends('layouts.base')

@section('content')
<section class="single-product">
    <div class="single-product__image">
        <img width="170" src="{{ asset($product->photo_path) }}" alt="{{ $product->name }}" />
    </div>
    <div class="single-product__info">
        <h1>
            {{ $product->name }}
        </h1>
        <p class="price">
            Our price: <span class="number">{{ $product->price }} €</span>
        </p>
        <div class="add-to-cart">
            <div class="change-cart-amount">
                <button data-change="+" onclick="changeValue(this)">+</button>
                <button data-change="-" onclick="changeValue(this)">-</button>
            </div>
            <input id="cart-amount" type="number" min="1" value="1" max="{{ $product->stock }}" />
            <button {{ $product->stock ? '' : 'style=text-decoration:line-through' }}
                data-json="{{ $product->toJson() }}"
                onclick="handleAddToBag(event, document.getElementById('cart-amount'))">Add To
                Bag</button>
        </div>
        @if ($product->stock > 0)
        <p class="stock">
            &#x2714; In stock
        </p>
        @else
        <p class="not-stock">
            &#x2717; Currently
            not in stock.
        </p>
        @endif
        <div class="shipping">
            <img src="{{ asset('/images/delivery-truck.svg') }}" alt="Free shipping icon">
            <p id="get-free-shipping">
                <span id="sum-to-free-shipping"></span>
            </p>
        </div>
        <h2 class="detail-title">
            Product detail
        </h2>
        <div class="detail">
            {{ $product->detail }}
        </div>
        <div id="read-more"></div>
    </div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script>
    const changeValue = (e) => {        
            let input = document.getElementById("cart-amount");
            let amount = parseInt(document.getElementById("cart-amount").value, 10);
            const sign = e.getAttribute("data-change");
            if (sign === "+") {
                amount++;
                
            } else if (amount > 0) {
                amount--;
            }
            if (input.max < amount || amount < 1) {
                return;
            }
            input.value = amount;
        }
</script>

<script src="{{ asset('./js/handleAddToBag.js') }}"></script>
<script>
    const readMore = document.getElementById("read-more");
        readMore.addEventListener("click", function(e){
        const prevSibling = e.target.previousElementSibling;
        prevSibling.classList.toggle("detail-open");
        readMore.classList.toggle("read-more-open");
    });
    const detailElement = document.querySelector(".detail");
    detailElement.addEventListener("click", function(){
        detailElement.classList.toggle("detail-open");
        readMore.classList.toggle("read-more-open");
    });
</script>

<script>
    setTimeout(function(){
        window.cartObj.setFreeShippingElement(document.getElementById('sum-to-free-shipping'));            
    }, 300);
</script>
@endpush