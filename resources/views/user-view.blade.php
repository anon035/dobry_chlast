@extends('layouts.base')

@section('content')
@include('components.category-menu', ['categories' => $categories, 'admin' => false])
@endsection
