@extends('layouts.admin_master')

@section('title', 'User Report')

@section('content')
    <div class="user-report-container">
        <h2 class="report-title">User Report</h2>

        <div class="table-responsive">
            <table class="user-report-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Message</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requests as $request)
                    <tr>
                        <td>{{ $request->name }}</td>
                        <td>{{ $request->email }}</td>
                        <td>{{ $request->phone }}</td>
                        <td>
                            <textarea class="message-textarea" readonly>{{ $request->message }}</textarea>
                        </td>
                        <td>{{ $request->created_at->format('M d, Y h:i A') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <style>
        /* Main Container */
        .user-report-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Title */
        .report-title {
            color: #2c3e50;
            font-size: 1.8rem;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ecf0f1;
        }

        /* Table Container */
        .table-responsive {
            overflow-x: auto;
            margin-bottom: 20px;
        }

        /* Table Styling */
        .user-report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        /* Table Header */
        .user-report-table thead th {
            background-color: #3498db;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        /* Table Rows */
        .user-report-table tbody tr {
            border-bottom: 1px solid #ecf0f1;
            transition: background-color 0.2s ease;
        }

        .user-report-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .user-report-table tbody tr:hover {
            background-color: #e9f7fe;
        }

        /* Table Cells */
        .user-report-table td {
            padding: 15px;
            color: #555;
            vertical-align: top;
        }

        /* Message Textarea */
        .message-textarea {
            width: 100%;
            min-height: 80px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
            resize: none;
            font-family: inherit;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        .message-textarea:focus {
            outline: none;
            border-color: #3498db;
            background-color: #fff;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .user-report-container {
                padding: 15px;
            }

            .user-report-table thead {
                display: none;
            }

            .user-report-table tbody tr {
                display: block;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }

            .user-report-table td {
                display: block;
                text-align: right;
                padding: 10px 15px;
                border-bottom: 1px solid #eee;
            }

            .user-report-table td::before {
                content: attr(data-label);
                float: left;
                font-weight: bold;
                color: #3498db;
            }

            .user-report-table td:last-child {
                border-bottom: none;
            }

            .message-textarea {
                min-height: 60px;
            }
        }
    </style>
@endsection
