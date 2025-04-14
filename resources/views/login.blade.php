@extends('layouts.login_master')
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
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        .is-invalid {
            border-color: #dc3545 !important;
        }

        .form-group {
            margin-bottom: 1rem;
        }
    </style>

    <section class="login-section fade-in">
        <div class="container">
            <h2>Login</h2>
            <div class="login-form">
                <!-- Error Message Container -->
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address"
                               value="{{ old('email') }}"
                               class="@error('email') is-invalid @enderror" required>
                    </div>

                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password"
                               class="@error('password') is-invalid @enderror" required>
                    </div>

                    <div class="form-group">
                        <select name="user_type" class="@error('user_type') is-invalid @enderror" required>
                            <option value="">Select User Type</option>
                            <option value="receiver" {{ old('user_type') == 'receiver' ? 'selected' : '' }}>Receiver</option>
                            <option value="donor" {{ old('user_type') == 'donor' ? 'selected' : '' }}>Donor</option>
                            <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <button type="submit">Login</button>
                </form>
                <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
            </div>
        </div>
    </section>
@endsection
