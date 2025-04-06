@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Blood Bank Details</h4>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p><strong>ID:</strong> {{ $bloodBank->id }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Admin ID:</strong> {{ $bloodBank->admin_id }}</p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Admin Name:</strong> {{ $bloodBank->admin_name }}</p>
                    </div>
                </div>

                <h5 class="mb-3">Blood Stock Availability</h5>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                        <tr>
                            <th>Blood Type</th>
                            <th>Units Available</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bloodBank->blood_availability as $type => $units)
                            <tr>
                                <td>{{ $type }}</td>
                                <td>{{ $units }}</td>
                                <td class="{{ $units > 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $units > 0 ? 'Available' : 'Not Available' }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer">
                <a href="{{ route('blood-banks.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>
    </div>
@endsection
