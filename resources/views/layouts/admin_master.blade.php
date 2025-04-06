<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hamro Blood Bank - Home</title>
    <meta name="description" content="Join Hamro Blood Bank to save lives. Donate blood, find donors, and learn why blood donation matters.">
    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Header */
        header {
            position: relative;
            background: linear-gradient(135deg, #ff4757 50%, #fff 50%);
            padding: 40px 0;
            text-align: center;
            overflow: hidden;
        }

        header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 1;
        }

        header .logo img {
            width: 150px; /* Adjust the width as needed */
        }

        header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            color: #ff4757; /* Red color for h1 */
        }

        header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 10px;
            color: #333; /* Dark text on the white side */
        }

        /* Navigation */
        nav {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        nav .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #ff4757;
        }

        /* Main Content */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .container h2 {
            font-size: 2.5rem;
            color: #ff4757;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        /* Cards Section */
        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 1.5rem;
            color: #ff4757;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1rem;
            color: #666;
        }

        /* Footer */
        footer {
            background: #333;
            color: #fff;
            padding: 40px 0;
            margin-top: 40px;
        }

        footer .footer-container {
            display: flex;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            flex-wrap: wrap;
            gap: 20px;
        }

        footer .footer-section {
            flex: 1;
            min-width: 200px;
        }

        footer .footer-section h3 {
            font-size: 1.5rem;
            color: #ff4757;
            margin-bottom: 15px;
        }

        footer .footer-section p {
            margin: 5px 0;
            font-size: 1rem;
        }

        footer .footer-section a {
            color: #ff4757;
            text-decoration: none;
        }

        footer .footer-section a:hover {
            text-decoration: underline;
        }

        footer .social-links {
            display: flex;
            gap: 10px;
        }

        footer .social-links a {
            color: #fff;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        footer .social-links a:hover {
            color: #ff4757;
        }

        footer .copyright {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Fade-in Animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
        }

        /* Hero Section */
        .hero-section {
            background-image: url('{{ asset("assets/images/home_background.webp") }}');
            background-size: cover;
            background-position: center;
            color: #fff;
            padding: 150px 20px;
            text-align: center;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: #fff;
        }

        .hero-content p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            color: #fff;
        }

        .hero-content .btn {
            padding: 10px 20px;
            background: #ff4757;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 500;
            transition: background 0.3s ease, transform 0.3s ease;
        }

        .hero-content .btn:hover {
            background: #ff6b6b;
            transform: translateY(-5px);
        }

        /* Statistics Section */
        .statistics-section {
            background: #fff;
            padding: 60px 20px;
            text-align: center;
        }

        .statistics-section h2 {
            color: #ff4757;
            margin-bottom: 40px;
        }

        .stats {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .stat {
            flex: 1;
            min-width: 200px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .stat:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .stat h3 {
            font-size: 2.5rem;
            color: #ff4757;
            margin-bottom: 10px;
        }

        .stat p {
            font-size: 1.1rem;
            color: #333;
        }

        /* How It Works Section */
        .how-it-works-section {
            background: #f8f9fa;
            padding: 60px 20px;
            text-align: center;
        }

        .how-it-works-section h2 {
            color: #ff4757;
            margin-bottom: 40px;
        }

        .steps {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .step {
            flex: 1;
            min-width: 250px;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .step:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .step-number {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            background: #ff4757;
            color: #fff;
            border-radius: 50%;
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .step h3 {
            font-size: 1.5rem;
            color: #ff4757;
            margin-bottom: 10px;
        }

        .step p {
            font-size: 1rem;
            color: #666;
        }

        /* Featured Stories Section */
        .featured-stories-section {
            background: #fff;
            padding: 60px 20px;
            text-align: center;
        }

        .featured-stories-section h2 {
            color: #ff4757;
            margin-bottom: 40px;
        }

        .stories {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .story {
            flex: 1;
            min-width: 250px;
            background: #f8f9fa;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .story:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .story img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .story h3 {
            font-size: 1.5rem;
            color: #ff4757;
            margin: 20px 0 10px;
        }

        .story p {
            font-size: 1rem;
            color: #666;
            padding: 0 20px 20px;
        }
    </style>
    @yield('css')
</head>
<body>
<!-- Header -->
<header class="fade-in">
    <div class="container">
        <div class="logo">
            <img src="{{asset('/assets/images/logo.png')}}" alt="Hamro Blood Bank Logo">
        </div>
        <div>
            <h1>Save Lives, Donate Blood</h1>
            <p>Join us in making a difference today.</p>
        </div>
    </div>
</header>

<!-- Navigation -->
<nav>
    <div class="container">
        <a href="#" class="logo"></a>
        <ul>
            <li><a href="{{url('admin_dashboard')}}">Receiver Request</a></li>
            <li><a href="{{url('donor_request')}}">Donor Request</a></li>
            <li><a href="{{url('blood_banks/index')}}">Blood Stock</a></li>
            <li><a href="{{url('user_detail')}}">User Detail</a></li>
            <li><a href="{{url('request_detail')}}">Request Details</a></li>
            <li><a href="{{url('admin_profile')}}">Profile</a></li>
        </ul>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer class="fade-in">
    <div class="footer-container">
        <!-- Contact Information -->
        <div class="footer-section">
            <h3>Contact Us</h3>
            <p><strong>Location:</strong> Kathmandu, Nepal</p>
            <p><strong>Phone:</strong> +977 123-456-7890</p>
            <p><strong>Email:</strong> info@hamrobloodbank.com</p>
        </div>

        <!-- Quick Links -->
        <div class="footer-section">
            <h3>Quick Links</h3>
            <p><a href="#home">Home</a></p>
            <p><a href="#about">About Us</a></p>
            <p><a href="#why-donate">Why Donate Blood</a></p>
            <p><a href="#login">Login</a></p>
        </div>

        <!-- Social Media Links -->
        <div class="footer-section">
            <h3>Follow Us</h3>
            <div class="social-links">
                <a href="https://facebook.com" target="_blank" aria-label="Facebook">
                    <i class="fab fa-facebook"></i>
                </a>
                <a href="https://twitter.com" target="_blank" aria-label="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://instagram.com" target="_blank" aria-label="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn">
                    <i class="fab fa-linkedin"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copyright">
        <p>&copy; 2025 Hamro Blood Bank. All rights reserved. | <a href="#privacy">Privacy Policy</a></p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Font Awesome CDN for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Simple JavaScript for Animations -->
<script>
    // Add fade-in animation to elements with the class "fade-in"
    const fadeElements = document.querySelectorAll('.fade-in');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.5 });

    fadeElements.forEach(element => {
        observer.observe(element);
    });
</script>
</body>
</html>
