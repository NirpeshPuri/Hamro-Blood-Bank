@extends('layouts.receiver_master')
@section('title', 'Home')
@section('content')
    <!-- Hero Section -->
    <section class="hero-section fade-in">
        <div class="hero-content">
            <h1>Save Lives, Donate Blood</h1>
            <p>Join us in making a difference today. Your donation can save up to 3 lives.</p>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics-section fade-in">
        <div class="container">
            <h2>Our Impact</h2>
            <div class="stats">
                <div class="stat">
                    <h3>10,000+</h3>
                    <p>Lives Saved</p>
                </div>
                <div class="stat">
                    <h3>5,000+</h3>
                    <p>Donors Registered</p>
                </div>
                <div class="stat">
                    <h3>100+</h3>
                    <p>Hospitals Supported</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works-section fade-in">
        <div class="container">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <span class="step-number">1</span>
                    <h3>Register</h3>
                    <p>Sign up as a donor or request blood in just a few simple steps.</p>
                </div>
                <div class="step">
                    <span class="step-number">2</span>
                    <h3>Donate or Find Blood</h3>
                    <p>Donate blood at a nearby center or find blood for patients in need.</p>
                </div>
                <div class="step">
                    <span class="step-number">3</span>
                    <h3>Save Lives</h3>
                    <p>Your contribution helps save lives and make a difference.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Stories Section -->
    <section class="featured-stories-section fade-in">
        <div class="container">
            <h2>Featured Stories</h2>
            <div class="stories">
                <div class="story">
                    <img src="{{ asset('assets/images/save_child.png') }}" alt="Story 1">
                    <h3>Alisha's Story</h3>
                    <p>Alisha donated blood and saved a child's life. Read his inspiring journey.</p>
                </div>
                <div class="story">
                    <img src="{{ asset('assets/images/save_father.jpg') }}" alt="Story 2">
                    <h3>Sanjip's Story</h3>
                    <p>Sanjip found a blood for his father through Hamro Blood Bank. Learn more.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
