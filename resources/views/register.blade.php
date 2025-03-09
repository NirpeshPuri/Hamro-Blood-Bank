@extends('layouts.frontend_master')
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
    </style>

    <section class="register-section fade-in">
        <div class="container">
            <h2>Register</h2>
            <div class="register-form">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <input type="text" name="name" placeholder="Full Name" required>
                    <input type="number" name="age" placeholder="Age" required>
                    <input type="number" name="weight" step="0.1" placeholder="Weight (kg)" required>
                    <input type="text" name="address" placeholder="Address" required>
                    <input type="tel" name="phone" placeholder="Phone Number" required>
                    <select name="blood_type" required>
                        <option value="">Select Blood Type</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                    <select name="user_type" required>
                        <option value="">Select User Type</option>
                        <option value="receiver">Receiver</option>
                        <option value="donor">Donor</option>
                    </select>
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                    <button type="submit">Register</button>
                </form>
                <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
            </div>
        </div>
    </section>
@endsection
