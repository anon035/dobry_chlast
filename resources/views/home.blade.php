@extends('layouts.base')

@section('content')
<section class="content">
    @forelse ($categories as $category)
    <div class="item">
        <span class="item__square">
            <a href="{{ route('products', ['category' => $category]) }}">
                <h2 class="item__title">{{ $category->name }}</h2>
                <p class="item__number">{{ $category->products_count }}
                    @if ($category->products_count == 1)
                    item
                    @else
                    items
                    @endif
                </p>
            </a>
        </span>
        <a style="background: url('{{ $category->photo_path }}') no-repeat center/contain;" href="{{ route('products', ['category' => $category]) }}">
        </a>
    </div>
    @empty
    No categories were found.
    @endforelse
</section>
<section class="content-desktop">
    <div class="jumbotron">
        <div class="jumbotron__image">
            <h1>Taste from</h1>
            <h1>around the Globe !</h1>
            <p>
                Explore
                and
                Enjoy !
            </p>
            <hr class="my-4">
            <p>
                Keep your head...
                Drink responsibly !
            </p>
        </div>
    </div>
    <div class="buy-process">
        <a href="{{ route('categories.user-view') }}">
            <div class="buy-process__place-order">
                <h3>Thirsty? Place an order!</h3>
                <p>
                    We got everything you'd like.
                </p>
                <img class="order" src="{{asset('./images/smartphone.svg')}}">
            </div>
        </a>
        <img class="buy-process__dotted-line" src="./images/curved-arrow-with-broken-line.svg">
        <div class="buy-process__place-order">
            <h3>We pack and deliver your order ASAP</h3>
            <p>
                We don't want you to be thirsty.
            </p>
            <img src="{{ asset('./images/delivery-truck.svg') }}">
        </div>
        <img class="buy-process__dotted-line" src="./images/scribble-broken-line.svg">
        <div class="buy-process__place-order">
            <h3>Enjoy !</h3>
            <p>
                Feel free to come back for more.
            </p>
            <img src="{{ asset('./images/drunk.svg') }}">
        </div>
    </div>
    <div id="special-offers" class="special-offers">
        <div class="special-offers__item">
            <img width="70" src="{{asset('./images/truck.svg')}}">
            <p>
                Free shipping over 99€
            </p>
        </div>
        <div class="special-offers__item">
            <img width="70" src="{{asset('./images/discount.svg')}}">
            <p>
                More you buy, less you pay
            </p>
        </div>
        <div class="special-offers__item">
            <img width="70" src="{{asset('./images/gift.svg')}}">
            <p>
                Special gifts for loyality
            </p>
        </div>
    </div>
</section>
</div>

@push('scripts')
<script>
    let target = document.querySelector("#special-offers");
        const offerItems = document.querySelectorAll(".special-offers__item");

        let options = {
            root: null,
            rootMargin: "0px",
            threshold: 0.5
        }

        let observer = new IntersectionObserver(function(e){
            if (e[0].intersectionRatio > 0) {
                offerItems[0].classList.add("anim1");
                offerItems[1].classList.add("anim2");
                offerItems[2].classList.add("anim3");
            }
        }, options);

        observer.observe(target);
</script>
@endpush
@endsection