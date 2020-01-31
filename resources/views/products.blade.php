@extends('layouts.base')

@section('content')
<section class="product-list">
    @if (count($products))
    @include('components.filter', ['prices' => $prices, 'json' => $products->toJson(), 'selector' => '.product-list__products'])
    @else
        <h2 class="no-products-in-category">
            No products in this category yet, but you can check <a class="link-special desktop-link" href="{{ route('categories.user-view') }}">the rest</a><a class="link-special mobile-link" href="{{ route('home') }}">the rest</a> 😉
        </h2>
    @endif
    <div class="product-list__products">
    </div>
</section>
@endsection

@if (count($products))
@push('scripts')
<script src="{{ asset('js/handleAddToBag.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
@endpush
@endif
