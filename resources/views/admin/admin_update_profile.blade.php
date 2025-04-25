@extends('layouts.admin_master')

@section('title', 'Admin Profile Settings')

@section('content')
    <style>
        /* Main Container */
        .container-fluid {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Profile Card */
        .profile-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        /* Header Section */
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 30px;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
        }

        .profile-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .back-btn {
            color: white;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 6px;
            background: rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Body Section */
        .profile-body {
            padding: 30px;
        }

        /* Alert Boxes */
        .alert-box {
            padding: 15px;
            margin-bottom: 25px;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            position: relative;
        }

        .alert-box.success {
            background-color: #e6f7ee;
            color: #28a745;
            border-left: 4px solid #28a745;
        }

        .alert-box.error {
            background-color: #fce8e8;
            color: #dc3545;
            border-left: 4px solid #dc3545;
        }

        .alert-close {
            background: none;
            border: none;
            color: inherit;
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
            font-size: 1.2rem;
        }

        /* Form Layout */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 30px;
        }

        @media (min-width: 992px) {
            .form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .form-section {
            background: #f9fafb;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .section-title {
            font-size: 1.2rem;
            margin-top: 0;
            margin-bottom: 20px;
            color: #374151;
            padding-bottom: 10px;
            border-bottom: 1px solid #e5e7eb;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .half-width {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #4b5563;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
        }

        .error-field {
            border-color: #ef4444;
        }

        .error-field:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .submit-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #1d4ed8;
        }

        .reset-btn {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
            padding: 12px 25px;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .reset-btn:hover {
            background: #e5e7eb;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .profile-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .half-width {
                width: 100%;
            }
        }
    </style>
    <div class="container-fluid px-4">
        <div class="profile-card shadow-sm">
            <div class="profile-header">
                <h2 class="profile-title">
                    <i class="fas fa-user-cog me-2"></i>Admin Profile Settings
                </h2>

            </div>

            <div class="profile-body">
                @if(session('success'))
                    <div class="alert-box success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button class="alert-close">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-box error">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button class="alert-close">&times;</button>
                    </div>
                @endif

                @if($errors->any()))
                <div class="alert-box error">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Please fix the following:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button class="alert-close">&times;</button>
                </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST" class="profile-form" id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="form-grid">
                        <!-- Personal Information Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-user me-2"></i>Personal Information
                            </h3>

                            <div class="form-group">
                                <label for="name">
                                    <i class="fas fa-signature me-1"></i> Full Name
                                </label>
                                <input type="text" id="name" name="name"
                                       class="@error('name') error-field @enderror"
                                       value="{{ old('name', $admin->name) }}" required
                                       pattern="[a-zA-Z ]+"
                                       title="Only alphabets and spaces allowed">
                                <small class="form-text">Only letters and spaces allowed</small>
                                @error('name')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">
                                    <i class="fas fa-envelope me-1"></i> Email
                                </label>
                                <input type="email" id="email" name="email"
                                       class="@error('email') error-field @enderror"
                                       value="{{ old('email', $admin->email) }}" required
                                       pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                       title="Please enter a valid email address">
                                @error('email')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">
                                    <i class="fas fa-phone me-1"></i> Phone
                                </label>
                                <input type="tel" id="phone" name="phone"
                                       class="@error('phone') error-field @enderror"
                                       value="{{ old('phone', $admin->phone) }}" required
                                       pattern="[0-9]{10}"
                                       title="10 digit phone number"
                                       maxlength="10">
                                <small class="form-text">10 digits only</small>
                                @error('phone')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Location Information Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-map-marker-alt me-2"></i>Location Information
                            </h3>

                            <div class="form-group">
                                <label for="address">
                                    <i class="fas fa-home me-1"></i> Address
                                </label>
                                <textarea id="address" name="address" rows="3"
                                          class="@error('address') error-field @enderror"
                                          required
                                          pattern="[a-zA-Z0-9\s,.-]+"
                                          title="Only letters, numbers, spaces, commas, dots and hyphens allowed">{{ old('address', $admin->address) }}</textarea>
                                @error('address')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-row">
                                <div class="form-group half-width">
                                    <label for="latitude">
                                        <i class="fas fa-map-pin me-1"></i> Latitude
                                    </label>
                                    <input type="text" id="latitude" name="latitude"
                                           class="@error('latitude') error-field @enderror"
                                           value="{{ old('latitude', $admin->latitude) }}" required>
                                    @error('latitude')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group half-width">
                                    <label for="longitude">
                                        <i class="fas fa-map-pin me-1"></i> Longitude
                                    </label>
                                    <input type="text" id="longitude" name="longitude"
                                           class="@error('longitude') error-field @enderror"
                                           value="{{ old('longitude', $admin->longitude) }}" required>
                                    @error('longitude')
                                    <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Password Update Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-lock me-2"></i>Password Update
                            </h3>

                            <div class="form-group">
                                <label for="password">
                                    <i class="fas fa-key me-1"></i> New Password (optional)
                                </label>
                                <input type="password" id="password" name="password"
                                       class="@error('password') error-field @enderror"
                                       pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$"
                                       title="Must contain at least one uppercase, one lowercase, one number and one special character">
                                <small class="form-text">Leave blank to keep current password</small>
                                <small class="form-text">Must contain: uppercase, lowercase, number, special character</small>
                                @error('password')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">
                                    <i class="fas fa-key me-1"></i> Confirm Password
                                </label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="@error('password_confirmation') error-field @enderror">
                                @error('password_confirmation')
                                <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">
                            <i class="fas fa-save me-2"></i>Save Changes
                        </button>
                        <button type="reset" class="reset-btn">
                            <i class="fas fa-undo me-2"></i>Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Phone number formatting
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9+]/g, '');
                });
            }

            // Close alert buttons
            const closeButtons = document.querySelectorAll('.alert-close');
            closeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            });

            // Form validation
            const form = document.getElementById('profileForm');
            if (form) {
                form.addEventListener('submit', function(event) {
                    if (!this.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    this.classList.add('was-validated');
                }, false);
            }

            // You could add map integration here for latitude/longitude
            // For example, using Google Maps API or similar
        });
    </script>
@endsection
