@extends('layouts.base')
@section('content')

<div class="stock-management">
    <h1>
        Categories list
    </h1>
    <a class="quick-add-button" href="{{ route('categories.create') }}">
        <button type="button">Create category</button>
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
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td class="product-image">
                    <img src="{{ asset($category->photo_path) }}" alt="{{ $category->name }}">
                </td>
                <td class="product-name">
                    {{ $category->name }}
                </td>
                <td>
                    <div class="action-wrapper">
                        <a href="{{ route('categories.edit', ['category' => $category]) }}">
                            <i title="Edit" alt="Edit button" class="far fa-edit edit-btn"></i>
                        </a>
                        <span title="Delete" alt="Delete button" class="delete-button edit-btn"
                            onclick="deleteCategory({{ $category->id }})">✖</span>
                        <form style="display:none;" method="POST" id="delete-form-{{ $category->id }}"
                            action="{{ route('categories.destroy', ['category' => $category]) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@push('scripts')

<script>
    const deleteCategory = (id) => {
            Swal.fire({
                title: 'Delete category?',
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