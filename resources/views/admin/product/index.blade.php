@extends('layouts.base')
@section('content')
<form action="{{ route('products.stock-update') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="stock-management">
        <h1>
            Products list
        </h1>
        <a class="quick-add-button" href="{{ route('products.create') }}">
            <button type="button">Create product</button>
        </a>
        <table>
            <thead>
                <tr>
                    <th>
                        Image
                    </th>
                    <th>
                        Name
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        In stock
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td class="product-image">
                        <img src="{{ asset($product->photo_path) }}" alt="{{ $product->name }}">
                    </td>
                    <td class="product-name">
                        {{ $product->name }}
                    </td>
                    <td>
                        {{ $product->category_name }}
                    </td>
                    <td>
                        {{ $product->price }}
                    </td>
                    <td class="product-stock">
                        <input type="text" name="products[{{ $product->id }}]" id="products[{{ $product->id }}]"
                            value="{{ $product->stock }}">
                    </td>
                    <td>
                        <div class="action-wrapper">
                            <a href="{{ route('products.edit', ['product' => $product]) }}">
                                <i title="Edit" alt="Edit button" class="far fa-edit edit-btn"></i>
                            </a>
                            <span title="Delete" alt="Delete button" class="delete-button edit-btn"
                                onclick="deleteProduct({{ $product->id }})">✖</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="btn-wrapper">
            <button class="submit" type="submit">
                Save
            </button>
        </div>
    </div>
</form>
@foreach ($products as $product)
<form style="display:none;" method="POST" id="delete-form-{{ $product->id }}"
    action="{{ route('products.destroy', ['product' => $product]) }}">
    @csrf
    @method('DELETE')
</form>
@endforeach
@endsection

@push('scripts')
<script>
    const deleteProduct = (id) => {
        Swal.fire({
            title: 'Delete product?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value){
                    document.getElementById('delete-form-' + id).submit();
                }
        })
    }
</script>
@endpush
