@extends('layouts.admin_master')
@section('title', 'My Blood Bank')
@section('content')

    <style>
        /* Blood Bank Show Page Styles */
        .bloodbank-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .bloodbank-title {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .bloodbank-card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
        }

        .bloodbank-header {
            background-color: #d32f2f;
            color: white;
            padding: 15px 20px;
        }

        .bloodbank-name {
            margin: 0;
            font-size: 1.4rem;
        }

        .bloodbank-body {
            padding: 20px;
        }

        .stock-title {
            margin: 0 0 15px 0;
            font-size: 1.2rem;
            color: #444;
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 0.95rem;
        }

        .stock-table th,
        .stock-table td {
            padding: 10px 8px;
            text-align: center;
        }

        .stock-table th {
            background-color: #f5f5f5;
            font-weight: 600;
            color: #333;
        }

        .stock-table td {
            border-bottom: 1px solid #eee;
        }

        .blood-type {
            font-weight: 600;
            color: #d32f2f;
        }

        .update-btn {
            display: inline-block;
            background-color: #d32f2f;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 15px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .update-btn:hover {
            background-color: #b71c1c;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .stock-table {
                font-size: 0.85rem;
            }

            .stock-table th,
            .stock-table td {
                padding: 8px 5px;
            }

            .bloodbank-body {
                padding: 15px;
            }
        }
    </style>
    <!--Show blood bank-->
    <div class="bloodbank-container">
        <h1 class="bloodbank-title">Blood Bank Stock</h1>

        <div class="bloodbank-card">
            <div class="bloodbank-header">
                <h2 class="bloodbank-name">{{ $bloodBank->admin_name ?? 'My' }} Blood Bank</h2>
            </div>

            <div class="bloodbank-body">

                <table class="stock-table">
                    <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Units Available</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                        <tr>
                            <td class="blood-type">{{ $type }}</td>
                            <td>{{ $bloodBank->$type }} units</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <a href="{{ route('blood-banks.update-form') }}" class="update-btn">
                    <i class="fas fa-edit"></i> Update Stock
                </a>
            </div>
        </div>
    </div>
@endsection
