@extends('layouts.base')

@section('content')
<div class="not-found-page">
    <div class="image">
        <p>4</p>
        <img src="{{ asset('images/glass.svg') }}" alt="404 error">
        <p>4</p>
    </div>
    <div class="text">
        Sorry, we couldn't find the page you were looking for.
    </div>
</div>
@endsection