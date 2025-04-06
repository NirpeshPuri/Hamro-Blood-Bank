@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ isset($bloodBank) ? 'Edit' : 'Create' }} Blood Bank</h4>
            </div>

            <div class="card-body">
                <form method="POST"
                      action="{{ isset($bloodBank) ? route('blood-banks.update', $bloodBank->id) : route('blood-banks.store') }}">
                    @csrf
                    @if(isset($bloodBank))
                        @method('PUT')
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="admin_id" class="form-label">Admin ID</label>
                            <input type="number" class="form-control" id="admin_id" name="admin_id"
                                   value="{{ old('admin_id', $bloodBank->admin_id ?? '') }}" required
                                {{ isset($bloodBank) ? 'readonly' : '' }}>
                            @error('admin_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="admin_name" class="form-label">Admin Name</label>
                            <input type="text" class="form-control" id="admin_name" name="admin_name"
                                   value="{{ old('admin_name', $bloodBank->admin_name ?? '') }}" required>
                            @error('admin_name')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Blood Availability</label>
                        <div class="blood-availability-grid">
                            @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                <div class="blood-type-input">
                                    <label for="blood_{{ $type }}">{{ $type }}</label>
                                    <input type="number" class="form-control"
                                           id="blood_{{ $type }}"
                                           name="blood_availability[{{ $type }}]"
                                           min="0"
                                           value="{{ old('blood_availability.'.$type, $bloodBank->blood_availability[$type] ?? 0) }}">
                                </div>
                            @endforeach
                        </div>
                        <input type="hidden" id="blood_availability_json" name="blood_availability">
                        @error('blood_availability')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('blood-banks.index') }}" class="btn btn-secondary me-2">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($bloodBank) ? 'Update' : 'Create' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .blood-availability-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
        }
        .blood-type-input {
            display: flex;
            flex-direction: column;
        }
        .blood-type-input label {
            font-weight: 500;
            margin-bottom: 5px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const bloodInputs = document.querySelectorAll('input[name^="blood_availability["]');
            const jsonInput = document.getElementById('blood_availability_json');

            function updateBloodJson() {
                const bloodData = {};
                bloodInputs.forEach(input => {
                    const type = input.name.match(/\[(.*?)\]/)[1];
                    bloodData[type] = parseInt(input.value) || 0;
                });
                jsonInput.value = JSON.stringify(bloodData);
            }

            // Initialize and update on change
            updateBloodJson();
            bloodInputs.forEach(input => {
                input.addEventListener('change', updateBloodJson);
            });

            // Form submission validation
            form.addEventListener('submit', function(e) {
                updateBloodJson();
                // Add any additional validation here
            });
        });
    </script>
@endsection
