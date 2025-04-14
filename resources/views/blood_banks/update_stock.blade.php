@extends('layouts.admin_master')
@section('title', 'Update Blood Stock')
@section('content')

    <style>
        /* Blood Bank Update Page Styles */
        .update-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 0 15px;
        }

        .update-title {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .update-card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            background: white;
        }

        .update-header {
            background-color: #1976d2;
            color: white;
            padding: 15px 20px;
        }

        .update-name {
            margin: 0;
            font-size: 1.4rem;
        }

        .update-body {
            padding: 20px;
        }

        .section-title {
            margin: 0 0 15px 0;
            font-size: 1.2rem;
            color: #444;
        }

        .stock-form {
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #1976d2;
            outline: none;
            box-shadow: 0 0 0 2px rgba(25, 118, 210, 0.2);
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: #1976d2;
            color: white;
        }

        .btn-primary:hover {
            background-color: #1565c0;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .stock-overview {
            margin-top: 30px;
        }

        /* Smaller table styles for update view */
        .stock-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 0.9rem; /* Smaller font size */
        }

        .stock-table th,
        .stock-table td {
            padding: 8px 10px; /* Reduced padding */
            text-align: center;
        }

        .stock-table th {
            background-color: #e3f2fd;
            font-weight: 600;
            color: #1976d2;
        }

        .stock-table td {
            border-bottom: 1px solid #eee;
        }

        .blood-type {
            font-weight: 600;
            color: #1976d2;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .form-actions {
                flex-direction: column;
                gap: 10px;
            }

            .btn {
                width: 100%;
            }

            .stock-table {
                font-size: 0.85rem; /* Even smaller on mobile */
            }

            .stock-table th,
            .stock-table td {
                padding: 6px 5px; /* More compact on mobile */
            }
        }
    </style>

    <div class="update-container">
        <h1 class="update-title">Update Blood Stock</h1>

        <div class="update-card">
            <div class="update-header">
                <h2 class="update-name">Manage Blood Units</h2>
            </div>

            <div class="update-body">
                <form action="{{ route('blood-banks.update') }}" method="POST" class="stock-form">
                    @csrf

                    <div class="form-group">
                        <label for="operation">Operation</label>
                        <select name="operation" id="operation" class="form-control" required>
                            <option value="add">Add Blood Units</option>
                            <option value="remove">Remove Blood Units</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="blood_type">Blood Type</label>
                        <select name="blood_type" id="blood_type" class="form-control" required>
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                <option value="{{ $type }}">{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Update Stock</button>
                        <a href="{{ route('blood-banks.show') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>

                <div class="stock-overview">
                    <h3 class="section-title">Current Stock Levels</h3>
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
                </div>
            </div>
        </div>
    </div>
@endsection
