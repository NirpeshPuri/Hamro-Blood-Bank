@extends('layouts.receiver_master')
@section('title', 'Payment')
@section('content')
    <style>
        .payment-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .payment-header {
            color: #ff4757;
            margin-bottom: 30px;
            text-align: center;
        }

        .payment-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .payment-form .form-group {
            margin-bottom: 15px;
        }

        .payment-form label {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .payment-form input, .payment-form select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .esewa-btn {
            background-color: #5C2D91;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
            width: 100%;
        }

        .esewa-btn:hover {
            background-color: #4a2473;
        }

        .esewa-icon {
            margin-right: 10px;
            font-size: 24px;
        }
    </style>
    <!--Edit Payment-->
    <div class="payment-container">
        <h1 class="payment-header">Complete Your Blood Request</h1>

        <div class="payment-details">
            <h3>Request Summary</h3>
         <!--   <p><strong>Blood Bank:</strong> }}</p>  -->
            <p><strong>Blood Type:</strong> {{ $bloodRequest['blood_group'] ?? 'N/A' }}</p>
            <p><strong>Request Type:</strong> {{ $bloodRequest['request_type'] ?? 'N/A' }}</p>
        </div>

        <form class="payment-form" action="{{ route('process.payment') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="blood_quantity">Blood Quantity (Units)</label>
                <input type="number" id="blood_quantity" name="blood_quantity" min="1" max="5"
                       value="{{ $bloodRequest['blood_quantity'] ?? 1 }}" required>
            </div>

            <div class="form-group">
                <label for="payment">Payment Amount (NPR)</label>
                <input type="number" id="payment_display" value="{{ $bloodRequest['payment'] ?? 0 }}" readonly>
                <input type="hidden" id="payment" name="payment" value="{{ $bloodRequest['payment'] ?? 0 }}">

            </div>

            <!-- Hidden fields for all required data -->
            <input type="hidden" name="blood_group" value="{{ $bloodRequest['blood_group'] }}">
            <input type="hidden" name="request_type" value="{{ $bloodRequest['request_type'] }}">
            <input type="hidden" name="admin_id" value="{{ $bloodRequest['admin_id'] }}">

            <button type="submit" class="esewa-btn">
                <span class="esewa-icon">💳</span>
                Pay with eSewa
            </button>
        </form>

        <script>
            document.getElementById('blood_quantity').addEventListener('input', function () {
                let units = parseInt(this.value) || 0;
                let payment = units * 500;
                document.getElementById('payment_display').value = payment.toFixed(2);
                document.getElementById('payment').value = payment.toFixed(2); // ✅ real field sent to backend
            });

            document.addEventListener('DOMContentLoaded', function () {
                let units = parseInt(document.getElementById('blood_quantity').value) || 0;
                let payment = units * 500;
                document.getElementById('payment_display').value = payment.toFixed(2);
                document.getElementById('payment').value = payment.toFixed(2); // ✅ real field sent to backend
            });

        </script>

    </div>
@endsection
