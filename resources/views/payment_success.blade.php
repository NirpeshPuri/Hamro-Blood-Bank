@extends('layouts.receiver_master')
@section('title', 'Payment Successful')
@section('content')
    <!--Payment Success-->
    <style>
        .payment-success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 2rem;
            background-color: #f8f9fa;
        }

        .payment-success-card {
            width: 100%;
            max-width: 650px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .payment-success-header {
            display: flex;
            align-items: center;
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, #5C2D91 0%, #7e4daf 100%);
            color: white;
        }

        .payment-success-icon {
            font-size: 2.5rem;
            margin-right: 1rem;
        }

        .payment-success-title h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .payment-success-title p {
            margin: 0;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .payment-success-body {
            padding: 2rem;
        }

        .payment-success-message {
            text-align: center;
            margin-bottom: 2rem;
        }

        .payment-success-message p {
            margin: 0.5rem 0;
            font-size: 1.1rem;
        }

        .payment-success-message p:first-child {
            font-weight: bold;
            font-size: 1.2rem;
            color: #5C2D91;
        }

        .payment-details {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .payment-details h3 {
            margin-top: 0;
            margin-bottom: 1rem;
            color: #5C2D91;
            text-align: center;
            font-size: 1.2rem;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
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
            background-color: #28a745;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .support-link {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #6c757d;
        }

        .support-link a {
            color: #5C2D91;
            text-decoration: none;
            font-weight: 600;
        }

        .action-button {
            text-align: center;
        }

        .btn-home {
            display: inline-block;
            background-color: #5C2D91;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-home:hover {
            background-color: #4a2473;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-home i {
            margin-right: 0.5rem;
        }
    </style>
    <!-- Payment Successful Page-->
    <div class="payment-success-container">
        <div class="payment-success-card">
            <div class="payment-success-header">
                <div class="payment-success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="payment-success-title">
                    <h2>Payment Successful</h2>
                    <p>Transaction completed</p>
                </div>
            </div>

            <div class="payment-success-body">
                <div class="payment-success-message">
                    <p>Thank you for your payment!</p>
                    <p>Your blood request #{{ $request_id  }} has been processed successfully.</p>
                </div>

                <div class="payment-details">
                    <h3>Transaction Details</h3>
                    <div class="detail-row">
                        <span class="detail-label">Request ID:</span>
                        <span class="detail-value">{{ $request_id  }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Transaction ID:</span>
                        <span class="detail-value">{{ $transaction_id }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Amount Paid:</span>
                        <span class="detail-value">NPR {{ $amount }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Status:</span>
                        <span class="status-badge">Completed</span>
                    </div>
                </div>

                <div class="action-button">
                    <a href="{{ route('receiver.dashboard') }}" class="btn-home">
                        <i class="fas fa-home"></i> Return to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>


@endsection
