@extends('layouts.receiver_master')
@section('title', 'Payment Failed')
@section('content')
    <!--Payment Failure-->
    <div class="payment-failure-container">
        <div class="payment-failure-card">
            <div class="payment-failure-header">
                <div class="payment-failure-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="payment-failure-title">
                    <h2>Payment Failed</h2>
                    <p>Transaction unsuccessful</p>
                </div>
            </div>

            <div class="payment-failure-body">
                <div class="payment-failure-message">
                    <div class="failure-animation">
                        <svg class="crossmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                            <circle class="crossmark__circle" cx="26" cy="26" r="25" fill="none"/>
                            <path class="crossmark__cross" fill="none" d="M16 16 36 36 M36 16 16 36"/>
                        </svg>
                    </div>
                    <h4>Payment Processing Failed</h4>
                    <p>We couldn't process your payment. Please try again.</p>
                </div>

                <div class="transaction-details">
                    <h5><i class="fas fa-exclamation-triangle"></i> Transaction Details</h5>
                    <div class="details-table">
                        <div class="detail-row">
                            <span class="detail-label">Transaction ID:</span>
                            <span class="detail-value">TXN-{{ rand(100000, 999999) }}</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="status-badge">Failed</span>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('receiver.dashboard') }}" class="btn-retry">
                        <i class="fas fa-redo"></i> Try Again
                    </a>
                    <a href="{{ route('receiver.dashboard') }}" class="btn-home">
                        <i class="fas fa-home"></i> Return to Dashboard
                    </a>
                </div>


            </div>
        </div>
    </div>

    <style>
        .payment-failure-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 2rem;
            background-color: #f8f9fa;
        }

        .payment-failure-card {
            width: 100%;
            max-width: 700px; /* Wider than before */
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .payment-failure-header {
            display: flex;
            align-items: center;
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, #dc3545 0%, #f14668 100%);
            color: white;
        }

        .payment-failure-icon {
            font-size: 2.5rem;
            margin-right: 1rem;
        }

        .payment-failure-title h2 {
            margin: 0;
            font-size: 1.8rem;
        }

        .payment-failure-title p {
            margin: 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .payment-failure-body {
            padding: 2.5rem;
        }

        .payment-failure-message {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .failure-animation {
            margin: 0 auto 1.5rem;
            width: 100px;
            height: 100px;
        }

        .crossmark {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            display: block;
            stroke-width: 5;
            stroke: #dc3545;
            stroke-miterlimit: 10;
            animation: fill 0.4s ease-in-out 0.4s forwards, scale 0.3s ease-in-out 0.9s both;
        }

        .crossmark__circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            stroke-width: 5;
            stroke-miterlimit: 10;
            stroke: #dc3545;
            fill: none;
            animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }

        .crossmark__cross {
            transform-origin: 50% 50%;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards;
        }

        .transaction-details {
            background-color: #fff5f5;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #dc3545;
        }

        .transaction-details h5 {
            text-align: center;
            color: #dc3545;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }

        .details-table {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f1c0c0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #495057;
        }

        .detail-value {
            color: #212529;
        }

        .status-badge {
            background-color: #dc3545;
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-retry, .btn-home {
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-retry {
            background-color: #dc3545;
            color: white;
            border: 2px solid #dc3545;
        }

        .btn-retry:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .btn-home {
            background-color: #5C2D91;
            color: white;
            border: 2px solid #5C2D91;
        }

        .btn-home:hover {
            background-color: #4a2473;
            transform: translateY(-2px);
        }

        .support-link {
            text-align: center;
            color: #6c757d;
        }

        .support-link a {
            color: #5C2D91;
            text-decoration: none;
            font-weight: 600;
        }

        @media (max-width: 576px) {
            .payment-failure-card {
                max-width: 95%;
            }
            .action-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            .btn-retry, .btn-home {
                width: 100%;
                text-align: center;
            }
        }
    </style>
@endsection
