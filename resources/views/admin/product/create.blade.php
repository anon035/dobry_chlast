@extends('layouts.base')

@section('content')


<div class="product-create">
    <h1><i class="fas fa-plus" aria-hidden="true"></i> Create product</h1>
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input required placeholder="Product name" autofocus type="text" name="name" id="name">
        <input required placeholder="Product photo" type="file" name="photo" id="photo">
        <input required placeholder="Product price" type="text" name="price" id="price">
        <input required placeholder="Products currently in stock" value="0" type="text" name="stock" id="stock">
        <select required name="category_id" id="category_id">
            <option value="">Choose Category</option>
            @foreach ($categories as $category)
            <option {{ $category->id == $selectedCategory ? 'selected' : '' }} value="{{ $category->id }}">
                {{ $category->name }}
            </option>
            @endforeach
        </select>
        <textarea required placeholder="Product detail info" rows="10" name="detail" id="detail"></textarea>
        <button type="submit">
            Create
        </button>
    </form>
</div>

@endsection
