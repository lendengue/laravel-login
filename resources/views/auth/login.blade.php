@extends('template.layout')

@section('title')
    <title>Login</title>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="login-form">
            <h2>Login</h2>
            @if (session('error'))
                <div class="error">
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
@endsection
