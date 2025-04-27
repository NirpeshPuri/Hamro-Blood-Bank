@extends('layouts.admin_master')
@section('title', 'Request Detail')
@section('content')

    <style>
        .custom-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            max-width: 90%;
            margin: 40px auto;
        }

        .custom-card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .custom-table {
            font-size: 1rem;
            width: 95%;
            margin: 0 auto;
            text-align: center;
        }

        .custom-table thead th {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 1.1rem;
            letter-spacing: 0.5px;
            color: white; /* Changed to white */
            background-color: #dc3545; /* Changed to red */
            border-top: none;
            padding: 15px; /* Added padding for better spacing */
        }

        .custom-table tbody td {
            padding: 0.8rem;
            vertical-align: middle;
        }

        .custom-table tbody tr:hover {
            background-color: rgba(220, 53, 69, 0.05) !important;
        }

        .type-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 16px;
            color: white;
        }

        .type-badge.request {
            background-color: #dc3545;
        }

        .type-badge.donation {
            background-color: #28a745;
        }

        .custom-badge {
            padding: 0.6em 1em;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
        }

        .emergency {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .rare {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .normal {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .status-badge {
            padding: 0.6em 1em;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .pending {
            background-color: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }

        .approved {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .rejected {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .blood-group {
            display: inline-block;
            padding: 0.4em 0.75em;
            font-size: 0.95rem;
            font-weight: 700;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
            color: #212529;
            border: 1px solid #dee2e6;
        }

        .table-title {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .custom-table {
                font-size: 0.95rem;
            }

            .custom-badge,
            .status-badge {
                font-size: 0.75rem;
                padding: 0.4em 0.6em;
            }

            .type-badge {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }
        }
    </style>

    <div class="container-fluid px-4">
        <div class="custom-card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="px-4 py-3 border-bottom">
                    <h4 class="table-title mb-0"><i class="fas fa-history mr-2"></i>Book Request & Donation History</h4>
                </div>

                <div class="table-responsive px-4 py-2">
                    <table class="table custom-table table-borderless mb-0">
                        <thead class="bg-light">
                        <tr>
                            <th></th>
                            <th>User Name</th>
                            <th>Blood Group</th>
                            <th>Quantity</th>
                            <th>Request Type</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($combinedHistory as $record)
                            <tr class="border-bottom">
                                <td>
                                    @if($record['type'] === 'request')
                                        <span class="type-badge request"><i class="fas fa-ambulance"></i></span>
                                    @else
                                        <span class="type-badge donation"><i class="fas fa-heart"></i></span>
                                    @endif
                                </td>

                                <td>
                                    <div class="font-weight-bold">{{ $record['user_name'] }}</div>
                                    <div class="text-muted small">{{ $record['email'] }}</div>
                                    <div class="text-muted small">{{ $record['phone'] }}</div>
                                </td>

                                <td>
                                    <span class="blood-group">{{ $record['blood_group'] ?? $record['blood_type'] }}</span>
                                </td>

                                <td>{{ $record['blood_quantity'] }} unit(s)</td>

                                <td>
                                    @if($record['type'] === 'request')
                                        @if($record['request_type'] === 'Emergency')
                                            <span class="custom-badge emergency"><i class="fas fa-bolt mr-1"></i> Emergency</span>
                                        @elseif($record['request_type'] === 'Rare')
                                            <span class="custom-badge rare"><i class="fas fa-star mr-1"></i> Rare</span>
                                        @else
                                            <span class="custom-badge normal">Normal</span>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>

                                <td>
                                    @if($record['status'] === 'pending')
                                        <span class="status-badge pending"><i class="fas fa-clock mr-1"></i> Pending</span>
                                    @elseif($record['status'] === 'approved')
                                        <span class="status-badge approved"><i class="fas fa-check mr-1"></i> Approved</span>
                                    @else
                                        <span class="status-badge rejected"><i class="fas fa-times mr-1"></i> Rejected</span>
                                    @endif
                                </td>

                                <td>
                                    @if($record['type'] === 'donation' && isset($record['donation_date']))
                                        {{ \Carbon\Carbon::parse($record['donation_date'])->format('M Y') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($record['created_at'])->format('M Y') }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">No records found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

@endsection
