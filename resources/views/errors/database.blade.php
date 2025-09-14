@extends('admin.main.app')
@section('content')

<div class="container mt-5 text-center">
    <h1 class="text-danger">Something went wrong</h1>
    <p class="lead">{{ $message }}</p>
    <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">Go Back</a>
</div>

@endsection
