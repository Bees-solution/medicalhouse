@extends('layouts.app')

@section('title', 'Shanthi Medical Home')

@section('content')


<div class="login-body">
    {{-- <img src="images/loginback.jpg" class="background-image"> --}}
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="*">
            @csrf
            <div class="mb-3 text-start">
                <label class="form-label">Enter your phone number</label>
                <div class="input-group">
                    <span class="input-group-text">👤</span>
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                </div>
            </div>
            <div class="mb-3 text-start">
                <label class="form-label">Enter your password</label>
                <div class="input-group">
                    <span class="input-group-text">🔒</span>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
                <a href="*" class="text-dark fw-bold text-decoration-none">Forgot Password?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>

@endsection
