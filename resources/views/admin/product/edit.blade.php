@extends('layouts.base')

@section('content')


<div class="product-create">
    <h1><i class="fas fa-sync" aria-hidden="true"></i> Edit product</h1>
    <form action="{{ route('products.update', ['product' => $product]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input required value="{{ $product->name }}" placeholder="Product name" autofocus type="text" name="name" id="name">
        <input placeholder="Product photo" type="file" name="photo" id="photo">
        <input required value="{{ $product->price }}" placeholder="Product price" type="text" name="price" id="price">
        <input required value="{{ $product->stock }}" placeholder="Products currently in stock" type="text" name="stock"
            id="stock">
        <select required name="category_id" id="category_id">
            <option value="">Choose Category</option>
            @foreach ($categories as $category)
            <option {{ $category->id == $product->category_id ? 'selected' : '' }} value="{{ $category->id }}">
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        <textarea required placeholder="Product detail info" rows="10" name="detail"
            id="detail">{{ $product->detail }}</textarea>
        <div>
            <p>
                Thumb image preview
            </p>
            <img width="30" src="{{ asset($product->photo_path) }}" alt="{{ $product->name }}">
        </div>
        <button type="submit">
            Edit
        </button>
    </form>
</div>

@endsection
