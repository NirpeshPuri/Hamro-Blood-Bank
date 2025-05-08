<!-- resources/views/edit_request.blade.php -->
@extends('layouts.receiver_master')
@section('title', 'Edit Request')
@section('content')
    <style>
        .edit-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
        }

        .edit-header {
            color: #ff4757;
            margin-bottom: 30px;
            text-align: center;
        }

        .edit-form .form-group {
            margin-bottom: 20px;
        }

        .edit-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #495057;
        }

        .edit-form input[type="text"],
        .edit-form input[type="number"],
        .edit-form input[type="email"],
        .edit-form input[type="tel"],
        .edit-form select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .edit-form input:focus,
        .edit-form select:focus {
            border-color: #ff4757;
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(255, 71, 87, 0.25);
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: #ff4757;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .file-info {
            margin-top: 10px;
            font-size: 14px;
            color: #6c757d;
        }

        .file-info a {
            color: #17a2b8;
            text-decoration: none;
        }

        .file-info a:hover {
            text-decoration: underline;
        }

        .current-file-image {
            max-width: 300px;
            max-height: 300px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 5px;
        }

        @media (max-width: 576px) {
            .edit-container {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
    <!-- Edit Receiver request-->
    <div class="edit-container">
        <h1 class="edit-header">Edit Blood Request</h1>

        <form class="edit-form" action="{{ route('receiver.request.update', $request->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="blood_group">Blood Group</label>
                <select id="blood_group" name="blood_group" class="form-control" required>
                    @foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $group)
                        <option value="{{ $group }}" {{ $request->blood_group == $group ? 'selected' : '' }}>
                            {{ $group }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="blood_quantity">Quantity (Units)</label>
                <input type="number" id="blood_quantity" name="blood_quantity"
                       min="1" value="{{ $request->blood_quantity }}" required>
            </div>

            <div class="form-group">
                <label for="request_type">Request Type</label>
                <select id="request_type" name="request_type" class="form-control" required>
                    <option value="Emergency" {{ $request->request_type == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                    <option value="Rare" {{ $request->request_type == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Normal" {{ $request->request_type == 'Normal' ? 'selected' : '' }}>Normal</option>
                </select>
            </div>

            <div class="form-group">
                <label for="payment">Payment Amount (NPR)</label>
                <input type="number" id="payment" name="payment"
                       min="0" step="0.01" value="{{ $request->payment }}" required>
            </div>

            <div class="form-group">
                <label for="request_form">Hospital Form (Proof)</label>
                <input type="file" id="request_form" name="request_form">

                @if($currentFileUrl)
                    <div class="file-info">
                        <p>Current file: <a href="{{ $currentFileUrl }}" target="_blank">View Full Size</a></p>
                        <img src="{{ $currentFileUrl }}" alt="Current hospital form" class="current-file-image">
                        <p class="mt-2"><small>Upload a new file only if you want to replace the current one</small></p>
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('receiver.status') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Request</button>
            </div>
        </form>
    </div>
@endsection
