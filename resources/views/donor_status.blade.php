@extends('layouts.donor_master')
@section('title', 'My Donations')
@section('content')
    <div class="request-container">
        <h1 class="request-header">My Blood Donations</h1>

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

        @if(!$eligibility['eligible'])
            <div class="next-donation">
                <strong>Next Eligible Donation Date:</strong>
                {{ $eligibility['next_donation_date']->format('M d, Y') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="request-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Blood Bank</th>
                    <th>Blood Type</th>
                    <th>Units</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Proof</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($donations as $donation)
                    <tr>
                        <td>#{{ $donation->id }}</td>
                        <td>{{ $donation->admin->name ?? 'N/A' }}</td>
                        <td>{{ $donation->blood_type }}</td>
                        <td>{{ $donation->blood_quantity }} units</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($donation->status) }}">
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td>{{ $donation->donation_date->format('M d, Y H:i') }}</td>
                        <td>
                            @if($donation->request_form)
                                <a href="{{ $donation->file_url }}"
                                   target="_blank"
                                   class="btn-action btn-view">
                                    View
                                </a>
                            @else
                                <span class="text-muted">None</span>
                            @endif
                        </td>
                        <td>
                            @if($donation->status === 'pending')
                                <div class="action-buttons">
                                    <a href="{{ route('donor.donation.edit', $donation->id) }}"
                                       class="btn-action btn-edit">Edit</a>
                                    <form action="{{ route('donor.donations.destroy', $donation->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete"
                                                onclick="return confirm('Are you sure you want to delete this donation request?')">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted">No actions available</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="no-requests">No donation records found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

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
        .btn-edit {
            background-color: #17A2B8;
            color: white;
        }
        .btn-delete {
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
        .next-donation {
            background-color: #E2E3E5;
            color: #383D41;
            border: 1px solid #D6D8DB;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
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
    </style>
@endsection
