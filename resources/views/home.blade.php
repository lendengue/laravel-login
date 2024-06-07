@extends('template.layout')

@section('title')
    <title>Home</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Welcome</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
@endsection
