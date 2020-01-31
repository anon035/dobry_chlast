@extends('layouts.base')

@section('content')
<div class="quick-add-product-button">
    <a href="{{ route('products.create', ['category' => $category->id]) }}">
        Create product
    </a>
</div>
<section class="product-list">
    @if (count($category->products))
    @php
    $products = $category->products;
    @endphp
    @include('components.filter', ['min' => $category->lowestPrice, 'max' => $category->highestPrice, 'json' => $products->toJson(), 'selector' => '.product-list__products'])
    @endif
    <div class="product-list__products">
    </div>
</section>
@endsection

@if (count($category->products))
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="{{ asset('js/handleAddToBag.js') }}"></script>
<script type="module">
    import Filter from "{{ asset('./js/Filter.js') }}";
        window.filter.render(document.querySelector(".product-list__products"), @json($category->products));
    </script>
@endpush
@endif
