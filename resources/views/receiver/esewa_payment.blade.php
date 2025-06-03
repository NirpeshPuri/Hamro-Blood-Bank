@extends('layouts.receiver_master')
@section('title', 'eSewa Payment')
@section('content')
    <style>
        .esewa-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 30px;
            text-align: center;
        }

        .esewa-header {
            color: #5C2D91;
            margin-bottom: 30px;
        }

        .payment-details {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .esewa-form {
            display: none;
        }

        .processing {
            font-size: 18px;
            margin: 20px 0;
        }
    </style>
    <!--After Edit Payment-->
    <div class="esewa-container">
        <h1 class="esewa-header">Redirecting to eSewa Payment</h1>

        <div class="payment-details">
            <h3>Payment Summary</h3>
            <p><strong>Blood Type:</strong> {{ $bloodRequest['blood_group'] }}</p>
            <p><strong>Quantity:</strong> {{ $bloodRequest['blood_quantity'] }} units</p>
            <p><strong>Amount:</strong> NPR {{($bloodRequest['payment']) }}</p>
        </div>

        <form id="esewaForm" class="esewa-form" action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
            <input type="hidden" name="amount" value="{{ $bloodRequest['payment'] }}">
            <input type="hidden" name="tax_amount" value="0">
            <input type="hidden" name="total_amount" value="{{ $bloodRequest['payment'] }}">
            <input type="hidden" name="transaction_uuid" value="{{ $transaction_uuid }}">
            <input type="hidden" name="product_code" value="{{ $product_code }}">
            <input type="hidden" name="product_service_charge" value="0">
            <input type="hidden" name="product_delivery_charge" value="0">
            <input type="hidden" name="success_url" value="{{ $success_url }}">
            <input type="hidden" name="failure_url" value="{{ $failure_url }}">
            <input type="hidden" name="signed_field_names" value="{{ $signed_field_names }}">
            <input type="hidden" name="signature" value="{{ $signature }}">
        </form>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    document.getElementById('esewaForm').submit();
                }, 2000);
            });
        </script>
    </div>
@endsection
