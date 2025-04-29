@extends('layouts.admin_master')
@section('title', 'Admin Dashboard')
@section('content')

    <style>
        .request-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .request-header {
            color: #ff4757;
            margin-bottom: 30px;
            text-align: center;
        }

        .request-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border-radius: 10px;
        }

        .request-table th {
            background-color: #ff4757;
            color: white;
            padding: 15px;
            text-align: left;
        }

        .request-table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .request-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .request-table tr:hover {
            background-color: #f1f1f1;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 14px;
            display: inline-block;
        }

        .status-pending {
            background-color: #FFC107;
            color: #212529;
        }

        .status-approved {
            background-color: #28A745;
            color: white;
        }

        .status-rejected {
            background-color: #DC3545;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-approve {
            background-color: #28A745;
            color: white;
        }

        .btn-reject {
            background-color: #DC3545;
            color: white;
        }

        .btn-view {
            background-color: #6C757D;
            color: white;
        }

        .btn-action:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .no-requests {
            text-align: center;
            padding: 40px;
            background-color: #f8f9fa;
            border-radius: 10px;
            margin-top: 20px;
            color: #6C757D;
        }

        .alert {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #D4EDDA;
            color: #155724;
            border: 1px solid #C3E6CB;
        }

        .alert-danger {
            background-color: #F8D7DA;
            color: #721C24;
            border: 1px solid #F5C6CB;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .user-contact {
            font-size: 16px;
            color: #6C757D;
        }

        .form-link {
            color: #007BFF;
            text-decoration: none;
            transition: color 0.3s;
        }

        .form-link:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .payment-input {
            width: 80px;
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ced4da;
        }

        .status-select {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ced4da;
            width: 100%;
        }

        @media (max-width: 768px) {
            .request-table {
                display: block;
                overflow-x: auto;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
        }
        .emergency-row {
            background-color: #ffebee !important; /* Light red */
        }
        .rare-row {
            background-color: #fff8e1 !important; /* Light yellow */
        }
        .normal-row {
            background-color: #e8f5e9 !important; /* Light green */
        }

        /* Type badges */
        .type-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: white;
            font-weight: bold;
        }
        .badge-emergency {
            background-color: #ff4757; /* Red */
        }
        .badge-rare {
            background-color: #ffa502; /* Orange/Yellow */
        }
        .badge-normal {
            background-color: #2ed573; /* Green */
        }
    </style>

    <div class="request-container">
        <h2 class="request-header">Receiver Blood Requests</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="request-table">
            <thead>
            <tr>
                <th>User</th>
                <th>Blood Group</th>
                <th>Quantity</th>
                <th>Type</th>
                <th>Status</th>
                <th>Request Form</th>
                <th>Payment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($requests as $requestItem)
                @if($requestItem->admin_id == Auth::guard('admin')->id())
                    @php
                        // Determine styling based on request_type
                        switch($requestItem->request_type) {
                            case 'Emergency':
                                $rowClass = 'emergency-row';
                                $badgeClass = 'badge-emergency';
                                $typeText = 'Emergency';
                                break;
                            case 'Rare':
                                $rowClass = 'rare-row';
                                $badgeClass = 'badge-rare';
                                $typeText = 'Rare';
                                break;
                            default: // normal
                                $rowClass = 'normal-row';
                                $badgeClass = 'badge-normal';
                                $typeText = 'Normal';
                        }
                    @endphp
                    <tr class="{{ $rowClass }}">
                        <td>
                            <div class="user-info">
                                <span class="user-name">{{ $requestItem->user_name }}</span>
                                <span class="user-contact">{{ $requestItem->email }}</span>
                                <span class="user-contact">{{ $requestItem->phone }}</span>
                            </div>
                        </td>
                        <td>{{ $requestItem->blood_group }}</td>
                        <td>{{ $requestItem->blood_quantity }} units</td>
                        <td>
                <span class="type-badge {{ $badgeClass }}">
                    {{ $typeText }}
                </span>
                        </td>
                        <td>
                <span class="status-badge status-{{ $requestItem->status }}">
                    {{ ucfirst($requestItem->status) }}
                </span>
                        </td>
                        <td>
                            @if($requestItem->request_form)
                                <a href="{{ $requestItem->file_url }}"
                                   target="_blank"
                                   class="btn-action btn-view">
                                    View
                                </a>
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $requestItem->payment ? 'Rs '.number_format($requestItem->payment, 2) : 'N/A' }}</td>
                        <td>{{ $requestItem->created_at->format('M d, Y') }}</td>
                        <td>
                            <form action="{{ route('admin.receiver.update-status', $requestItem->id) }}" method="POST">
                                @csrf
                                <div class="action-buttons">
                                    <button type="submit" name="action" value="approve" class="btn-action btn-approve">
                                        Approve
                                    </button>
                                    <button type="submit" name="action" value="reject" class="btn-action btn-reject">
                                        Reject
                                    </button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="9" class="no-requests">No blood requests assigned to you</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

@endsection
