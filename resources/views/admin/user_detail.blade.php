@extends('layouts.admin_master')
@section('title', 'User Management')
@section('content')

    <div class="request-container">
        <h2 class="request-header">User Details</h2>

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

        <div class="table-responsive">
            <table class="request-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Weight</th>
                    <th>Blood Type</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Registered</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->age ?? 'N/A' }}</td>
                        <td>{{ $user->weight ? $user->weight.' kg' : 'N/A' }}</td>
                        <td>{{ $user->blood_type ?? 'N/A' }}</td>
                        <td>{{ $user->phone ?? 'N/A' }}</td>
                        <td>{{ Str::limit($user->email, 20) }}</td>
                        <td>
                                <span class="badge
                                    @if($user->user_type === 'receiver') badge-success
                                    @elseif($user->user_type === 'donor') badge-info
                                    @else badge-secondary @endif">
                                    {{ ucfirst($user->user_type) }}
                                </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this user?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
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
            font-size: 13px;
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
    </style>

@endsection
