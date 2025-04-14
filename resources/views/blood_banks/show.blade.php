@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Blood Bank Details</h1>

        <div class="card">
            <div class="card-header">
                <h2>{{ $bloodBank->admin_name }}'s Blood Bank</h2>
            </div>
            <div class="card-body">
                <h3 class="card-title">Blood Stock</h3>
                <div class="row">
                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-header bg-danger text-white">
                                    {{ $type }}
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">{{ $bloodBank->$type }} units</h4>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <a href="{{ route('blood-banks.update-stock-form', $bloodBank) }}" class="btn btn-primary">Update Stock</a>
                <a href="{{ route('blood-banks.edit', $bloodBank) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('blood-banks.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
@endsection
