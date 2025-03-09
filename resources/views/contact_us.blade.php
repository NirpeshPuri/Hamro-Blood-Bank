@extends('layouts.frontend_master')
@section('title', 'Contact Us')
@section('content')
    <style>
        /* Add your CSS styles here */
        .contact-section {
            padding: 60px 20px;
            background: #f8f9fa;
            text-align: center;
        }

        .contact-section h2 {
            color: #ff4757;
            margin-bottom: 40px;
        }

        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .contact-form input, .contact-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .contact-form input:focus, .contact-form textarea:focus {
            border-color: #ff4757;
            outline: none;
        }

        .contact-form textarea {
            resize: vertical;
            height: 150px;
        }

        .contact-form button {
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

        .contact-form button:hover {
            background: #ff6b6b;
            transform: translateY(-3px);
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 1rem;
        }

        .alert-success {
            background-color: #d4edda; /* Light green background */
            color: #155724; /* Dark green text */
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da; /* Light red background */
            color: #721c24; /* Dark red text */
            border: 1px solid #f5c6cb;
        }
    </style>

    <!-- Contact Section -->
    <section class="contact-section fade-in">
        <div class="container">
            <h2>Contact Us</h2>
            <div class="contact-form">
                <!-- Display success message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Display error message -->
                @if(session('error'))
                    <div class="alert alert-error">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ url('/submit-contact-form') }}" method="POST">
                    @csrf <!-- CSRF token for security -->
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email Address" required>
                    <input type="tel" name="phone" placeholder="Your Phone Number" required>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
    </section>
@endsection
