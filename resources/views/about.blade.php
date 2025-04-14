@extends('layouts.receiver_master')
@section('title', 'About_us')
@section('content')
    <style>
        /* Reuse the same styles from the home page */
        /* Add additional styles if needed */
        .about-section {
            padding: 60px 20px;
            background: #f8f9fa;
            text-align: center;
        }

        .about-section h2 {
            color: #ff4757;
            margin-bottom: 40px;
        }

        .about-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            margin-bottom: 20px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .eligibility-section, .branches-section {
            background: #fff;
            padding: 60px 20px;
            text-align: center;
        }

        .eligibility-section h2, .branches-section h2 {
            color: #ff4757;
            margin-bottom: 40px;
        }

        .eligibility-criteria, .branch-list {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .eligibility-criteria .criteria, .branch-list .branch {
            flex: 1;
            min-width: 250px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .eligibility-criteria .criteria:hover, .branch-list .branch:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .eligibility-criteria h3, .branch-list h3 {
            font-size: 1.5rem;
            color: #ff4757;
            margin-bottom: 10px;
        }

        .eligibility-criteria ul {
            list-style: none;
            padding: 0;
        }

        .eligibility-criteria ul li {
            font-size: 1rem;
            color: #666;
            margin-bottom: 10px;
        }

        .branch-list p {
            font-size: 1rem;
            color: #666;
        }
    </style>

    <!-- About Section -->
    <section class="about-section fade-in">
        <div class="container">
            <h2>About Hamro Blood Bank</h2>
            <p>
                Hamro Blood Bank is an organization dedicated to saving lives by connecting blood donors with those in need.
                Our mission is to ensure a steady supply of safe blood for patients in hospitals across Nepal.
                We believe that every drop of blood can make a difference, and we are committed to making the donation process simple and accessible for everyone.
            </p>
        </div>
    </section>

    <!-- Eligibility Section -->
    <section class="eligibility-section fade-in">
        <div class="container">
            <h2>Who Can Donate Blood?</h2>
            <div class="eligibility-criteria">
                <div class="criteria">
                    <h3>Age</h3>
                    <ul>
                        <li>Must be between 18 and 65 years old.</li>
                        <li>Donors aged 16-17 may donate with parental consent.</li>
                    </ul>
                </div>
                <div class="criteria">
                    <h3>Weight</h3>
                    <ul>
                        <li>Must weigh at least 50 kg (110 lbs).</li>
                        <li>Weight requirements may vary for platelet donation.</li>
                    </ul>
                </div>
                <div class="criteria">
                    <h3>Health</h3>
                    <ul>
                        <li>Must be in good health and free from infectious diseases.</li>
                        <li>Should not have donated blood in the last 3 months.</li>
                        <li>Must have normal blood pressure and hemoglobin levels.</li>
                        <li>Should not have a cold, flu, or other infections at the time of donation.</li>
                    </ul>
                </div>
                <div class="criteria">
                    <h3>Lifestyle</h3>
                    <ul>
                        <li>Should not have a history of drug abuse or risky sexual behavior.</li>
                        <li>Must not be pregnant or breastfeeding.</li>
                        <li>Should not have gotten a tattoo or piercing in the last 6 months.</li>
                        <li>Must not have traveled to malaria-endemic areas recently.</li>
                    </ul>
                </div>
                <div class="criteria">
                    <h3>Medical History</h3>
                    <ul>
                        <li>Should not have a history of heart disease, cancer, or blood disorders.</li>
                        <li>Must not be on antibiotics or other medications that affect blood donation.</li>
                    </ul>
                </div>
                <div class="criteria">
                    <h3>Post-Donation</h3>
                    <ul>
                        <li>Drink plenty of fluids and avoid strenuous activity for 24 hours.</li>
                        <li>Eat iron-rich foods to replenish lost nutrients.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Branches Section -->
    <section class="branches-section fade-in">
        <div class="container">
            <h2>Our Branches</h2>
            <div class="branch-list">
                <div class="branch">
                    <h3>Chabahil Blood Bank</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Chabahil, Kathmandu</p>
                    <p><i class="fas fa-phone"></i> 9800000001</p>
                    <p><i class="fas fa-envelope"></i> chabahil@gmail.com</p>
                    <div class="branch-coordinates">
                        <small>Coordinates: 27.71857882, 85.34833882</small>
                    </div>
                </div>

                <div class="branch">
                    <h3>Exhibition Blood Bank</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Exhibition Road, Kathmandu</p>
                    <p><i class="fas fa-phone"></i> 9800000002</p>
                    <p><i class="fas fa-envelope"></i> exhibition@gmail.com</p>
                    <div class="branch-coordinates">
                        <small>Coordinates: 27.70211487, 85.32002475</small>
                    </div>
                </div>

                <div class="branch">
                    <h3>Soaltee Mod Blood Bank</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Himalayan Heights, Soaltee Mod</p>
                    <p><i class="fas fa-phone"></i> 9800000003</p>
                    <p><i class="fas fa-envelope"></i> soalteemod@gmail.com</p>
                    <div class="branch-coordinates">
                        <small>Coordinates: 27.69914224, 85.29062838</small>
                    </div>
                </div>

                <div class="branch">
                    <h3>Lalitpur Blood Bank</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Pulchowk Rd, Lalitpur</p>
                    <p><i class="fas fa-phone"></i> 9800000004</p>
                    <p><i class="fas fa-envelope"></i> lalitpur@gmail.com</p>
                    <div class="branch-coordinates">
                        <small>Coordinates: 27.67557246, 85.31288775</small>
                    </div>
                </div>

                <div class="branch">
                    <h3>Kantipur Blood Bank</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Shri Ganesh Marg, Kathmandu</p>
                    <p><i class="fas fa-phone"></i> 9800000005</p>
                    <p><i class="fas fa-envelope"></i> kantipur@gmail.com</p>
                    <div class="branch-coordinates">
                        <small>Coordinates: 27.68568049, 85.34503177</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
