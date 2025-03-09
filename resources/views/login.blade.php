@extends('layouts.frontend_master')
@section('title', 'Login')
@section('content')
    <style>
        .login-section {
            padding: 60px 20px;
            background: #f8f9fa;
            text-align: center;
        }

        .login-form {
            max-width: 400px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-form input, .login-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .login-form button {
            padding: 10px 20px;
            background: #ff4757;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .login-form button:hover {
            background: #ff6b6b;
            transform: translateY(-3px);
        }
    </style>

    <section class="login-section fade-in">
        <div class="container">
            <h2>Login</h2>
            <div class="login-form">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <select name="user_type" required>
                        <option value="">Select User Type</option>
                        <option value="receiver">Receiver</option>
                        <option value="donor">Donor</option>
                        <option value="admin">Admin</option>
                    </select>
                    <button type="submit">Login</button>
                </form>
                <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
            </div>
        </div>
    </section>
@endsection
