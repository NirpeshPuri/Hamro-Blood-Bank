@extends('layouts.donor_master')
@section('title', 'Update Profile')
@section('content')
    <div class="update-section">
        <div class="update-form">
            <div class="card-header">{{ __('Update Profile') }}</div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="@error('name') is-invalid @enderror"
                           name="name" value="{{ old('name', $user->name) }}" required autocomplete="name" autofocus>
                    @error('name')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email') }}</label>
                    <input id="email" type="email" class="@error('email') is-invalid @enderror"
                           name="email" value="{{ old('email', $user->email) }}" required autocomplete="email">
                    @error('email')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="age">{{ __('Age') }}</label>
                        <input id="age" type="number" class="@error('age') is-invalid @enderror"
                               name="age" value="{{ old('age', $user->age) }}" required>
                        @error('age')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="weight">{{ __('Weight (kg)') }}</label>
                        <input id="weight" type="number" step="0.1" class="@error('weight') is-invalid @enderror"
                               name="weight" value="{{ old('weight', $user->weight) }}" required>
                        @error('weight')
                        <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">{{ __('Address') }}</label>
                    <input id="address" type="text" class="@error('address') is-invalid @enderror"
                           name="address" value="{{ old('address', $user->address) }}" required>
                    @error('address')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">{{ __('Phone Number') }}</label>
                    <input id="phone" type="tel" class="@error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone', $user->phone) }}" required>
                    @error('phone')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="blood_type">{{ __('Blood Type') }}</label>
                    <select id="blood_type" class="@error('blood_type') is-invalid @enderror" name="blood_type" required>
                        <option value="">Select Blood Type</option>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                            <option value="{{ $type }}" {{ old('blood_type', $user->blood_type) == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                    @error('blood_type')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="current_password">{{ __('Current Password') }}</label>
                    <input id="current_password" type="password" class="@error('current_password') is-invalid @enderror"
                           name="current_password" required>
                    @error('current_password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="new_password">{{ __('New Password') }}</label>
                    <input id="new_password" type="password" class="@error('new_password') is-invalid @enderror"
                           name="new_password">
                    @error('new_password')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                    <small class="form-text">Leave blank if you don't want to change</small>
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">{{ __('Confirm New Password') }}</label>
                    <input id="new_password_confirmation" type="password" name="new_password_confirmation">
                </div>

                <button type="submit">
                    <i class="fas fa-save"></i> {{ __('Update Profile') }}
                </button>
            </form>
        </div>
    </div>

    <style>
        .update-section {
            padding: 60px 20px;
            background: #f8f9fa;
            text-align: center;
        }

        .update-form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .update-form .card-header {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .update-form .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .update-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .update-form input,
        .update-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .update-form .form-row {
            display: flex;
            gap: 20px;
        }

        .update-form .form-row .form-group {
            flex: 1;
        }

        .update-form button {
            width: 100%;
            padding: 12px;
            background: #ff4757;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .update-form button:hover {
            background: #ff6b6b;
            transform: translateY(-3px);
        }

        .update-form button i {
            margin-right: 8px;
        }

        .error-message {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }

        .form-text {
            color: #6c757d;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection
