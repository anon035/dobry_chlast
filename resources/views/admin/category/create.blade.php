@extends('layouts.base')

@section('content')


<div class="category-create">
    <h1><i class="fas fa-plus" aria-hidden="true"></i> Create category</h1>
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input required placeholder="Category name" type="text" name="name" id="name">
        <input required placeholder="Category thumb photo" type="file" name="photo" id="photo">
        <button type="submit">
            Create
        </button>
    </form>
</div>

@endsection