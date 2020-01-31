@extends('layouts.base')

@section('content')


<div class="category-create">
    <h1><i class="fas fa-sync" aria-hidden="true"></i> Edit category</h1>
    <form action="{{ route('categories.update', ['category' => $category]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input required value="{{ $category->name }}" placeholder="Category name" type="text" name="name" id="name">
        <input required placeholder="Category thumb photo" type="file" name="photo" id="photo">
        <div>
            <p>
                Thumb preview
            </p>
            <img width="30" src="{{ asset($category->photo_path) }}" alt="{{ $category->name }}">
        </div>
        <button type="submit">
            Edit
        </button>
    </form>
</div>



@endsection