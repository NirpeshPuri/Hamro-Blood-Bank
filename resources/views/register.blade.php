@extends('layouts.login_master')
@section('title', 'Register')
@section('content')
    <style>
        .register-section {
            padding: 60px 20px;
            background: #f8f9fa;
            text-align: center;
        }

        .register-form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .register-form input, .register-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .register-form button {
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

        .register-form button:hover {
            background: #ff6b6b;
            transform: translateY(-3px);
        }
        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: -15px;
            margin-bottom: 10px;
        }

    </style>
    @error('field')
    <div class="error-message">{{ $message }}</div>
    @enderror

    <section class="register-section fade-in">
        <div class="container">
            <h2>Register</h2>
            <div class="register-form">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
                    @error('name') <div class="error-message">{{ $message }}</div> @enderror

                    <input type="number" name="age" value="{{ old('age') }}" placeholder="Age (Above 16)" required>
                    @error('age') <div class="error-message">{{ $message }}</div> @enderror

                    <input type="number" name="weight" value="{{ old('weight') }}" step="0.1" placeholder="Weight (kg) (Above 45)" required>
                    @error('weight') <div class="error-message">{{ $message }}</div> @enderror

                    <input type="text" name="address" value="{{ old('address') }}" placeholder="Address" required>
                    @error('address') <div class="error-message">{{ $message }}</div> @enderror

                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" required>
                    @error('phone') <div class="error-message">{{ $message }}</div> @enderror

                    <select name="blood_type" required>
                        <option value="">Select Blood Type</option>
                        <option value="A+" {{ old('blood_type') == 'A+' ? 'selected' : '' }}>A+</option>
                        <option value="A-" {{ old('blood_type') == 'A-' ? 'selected' : '' }}>A-</option>
                        <option value="B+" {{ old('blood_type') == 'B+' ? 'selected' : '' }}>B+</option>
                        <option value="B-" {{ old('blood_type') == 'B-' ? 'selected' : '' }}>B-</option>
                        <option value="AB+" {{ old('blood_type') == 'AB+' ? 'selected' : '' }}>AB+</option>
                        <option value="AB-" {{ old('blood_type') == 'AB-' ? 'selected' : '' }}>AB-</option>
                        <option value="O+" {{ old('blood_type') == 'O+' ? 'selected' : '' }}>O+</option>
                        <option value="O-" {{ old('blood_type') == 'O-' ? 'selected' : '' }}>O-</option>
                    </select>
                    @error('blood_type') <div class="error-message">{{ $message }}</div> @enderror

                    <select name="user_type" required>
                        <option value="">Select User Type</option>
                        <option value="receiver" {{ old('user_type') == 'receiver' ? 'selected' : '' }}>Receiver</option>
                        <option value="donor" {{ old('user_type') == 'donor' ? 'selected' : '' }}>Donor</option>
                    </select>
                    @error('user_type') <div class="error-message">{{ $message }}</div> @enderror

                    <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                    @error('email')
                    <div style="color: red;">{{ $message }}</div>
                    @enderror


                    <input type="password" name="password" placeholder="Password" required>
                    @error('password') <div class="error-message">{{ $message }}</div> @enderror

                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    @error('password_confirmation') <div class="error-message">{{ $message }}</div> @enderror

                    <button type="submit">Register</button>
                </form>
                <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>

                <a href="{{ route('login') }}">Go Back</a></p>
            </div>
        </div>
    </section>
@endsection
