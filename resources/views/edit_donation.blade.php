@extends('layouts.donor_master')
@section('title', 'Edit Donation')
@section('content')
    <div class="request-container">
        <h1 class="request-header">Edit Donation Request</h1>

        <form action="{{ route('donor.donation.update', $donation->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Blood Bank</label>
                <input type="text" class="form-control" value="{{ $donation->admin->name ?? 'N/A' }}" readonly>
            </div>

            <div class="form-group">
                <label>Blood Type</label>
                <input type="text" class="form-control" value="{{ $donation->blood_type }}" readonly>
            </div>

            <div class="form-group">
                <label for="blood_quantity">Units</label>
                <input type="number" id="blood_quantity" name="blood_quantity"
                       class="form-control" min="1" max="10"
                       value="{{ $donation->blood_quantity }}" required>
            </div>

            <div class="form-group">
                <label for="request_form">Medical Proof</label>
                <input type="file" id="request_form" name="request_form" class="form-control"
                       accept=".jpeg,.png,.pdf">

                @if($donation->request_form)
                    <div class="current-file mt-3">
                        <p>Current file:
                            <a href="{{ $donation->file_url }}" target="_blank" class="text-blue-600">View</a>
                        </p>
                        @if(Str::endsWith($donation->request_form, ['.jpg', '.jpeg', '.png']))
                            <img src="{{ $donation->file_url }}" class="max-w-xs mt-2 border rounded">
                        @endif
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('donor.status') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>

    <style>
        .request-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .request-header {
            color: #ff4757;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #ff4757;
            color: white;
            border: none;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
        }
        .current-file img {
            max-width: 300px;
            max-height: 200px;
        }
    </style>
@endsection
