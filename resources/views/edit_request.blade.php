<!-- resources/views/edit_request.blade.php -->
@extends('layouts.receiver_master')
@section('title', 'Edit Request')
@section('content')
    <!--Edit Request-->
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
    <!--Edit Blood Request-->
    <div class="edit-container">
        <h1 class="edit-header">Edit Blood Request</h1>

        <form class="edit-form" action="{{ route('receiver.request.update', $request->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            @csrf
            @method('PUT')

            <input type="hidden" id="adminId" name="admin_id" value="{{ $adminId }}">

            <div class="form-group">
                <label for="blood_group">Blood Group</label>
                <select id="blood_group" name="blood_group" class="form-control" required onchange="handleBloodGroupChange()">
                    @php
                        $userBloodType = auth()->user()->blood_type ?? null;
                        $rareBloodTypes = ['AB-', 'B-', 'A-'];
                        $compatibleTypes = [
                            'A+' => ['A+', 'A-', 'O+', 'O-'],
                            'A-' => ['A-', 'O-'],
                            'B+' => ['B+', 'B-', 'O+', 'O-'],
                            'B-' => ['B-', 'O-'],
                            'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
                            'AB-' => ['A-', 'B-', 'AB-', 'O-'],
                            'O+' => ['O+', 'O-'],
                            'O-' => ['O-']
                        ];
                        $allowedTypes = $compatibleTypes[$userBloodType] ?? array_keys($compatibleTypes);
                    @endphp

                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                        @if(in_array($type, $allowedTypes))
                            <option value="{{ $type }}"
                                    {{ $type == $request->blood_group ? 'selected' : '' }}
                                    data-is-rare="{{ in_array($type, $rareBloodTypes) ? 'true' : 'false' }}">
                                {{ $type }}
                            </option>
                        @endif
                    @endforeach
                </select>
                <small class="text-muted">
                    @if($userBloodType)
                        Your blood type: {{ $userBloodType }} (showing compatible types)
                    @else
                        Please set your blood type in your profile
                    @endif
                </small>
            </div>

            <div class="form-group">
                <label for="blood_quantity">Quantity (Units)</label>
                <input type="number" id="blood_quantity" name="blood_quantity" min="1" value="{{ $request->blood_quantity }}" readonly>
            </div>

            <div class="form-group">
                <label for="request_type">Request Type</label>
                <select id="request_type" name="request_type" class="form-control" required>
                    <option value="Emergency" {{ $request->request_type == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                    <option value="Rare" id="rareOption" {{ $request->request_type == 'Rare' ? 'selected' : '' }}
                    @if(!in_array($request->blood_group, $rareBloodTypes)) disabled @endif>
                        Rare
                    </option>
                    <option value="Normal" {{ $request->request_type == 'Normal' ? 'selected' : '' }}>Normal</option>
                </select>
                <small class="text-muted">Rare Blood Types are (AB-, B-, A-)</small>
            </div>

            <div class="form-group">
                <label for="payment">Payment Amount (NPR)</label>
                <input type="number" id="payment" name="payment" min="0" step="0.01" value="{{ $request->payment }}" readonly>
            </div>

            <div class="form-group">
                <label for="request_form">Hospital Form (Proof)</label>
                <input type="file" id="request_form" name="request_form">

                @if(!empty($currentFileUrl))
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

    <script>
        // Stock data passed from backend (controller)
        const stock = @json($stock);

        function handleBloodGroupChange() {
            const bloodGroupSelect = document.getElementById('blood_group');
            const selectedOption = bloodGroupSelect.options[bloodGroupSelect.selectedIndex];
            const isRare = selectedOption.getAttribute('data-is-rare') === 'true';

            const rareOption = document.getElementById('rareOption');
            const requestTypeSelect = document.getElementById('request_type');

            // Enable/disable Rare option based on blood group
            if (isRare) {
                rareOption.disabled = false;
            } else {
                rareOption.disabled = true;
                if (requestTypeSelect.value === 'Rare') {
                    requestTypeSelect.value = 'Normal';
                }
            }

            checkQuantityAgainstStock();
        }

        function checkQuantityAgainstStock() {
            const bloodGroup = document.getElementById('blood_group').value;
            const quantity = parseInt(document.getElementById('blood_quantity').value);
            const available = stock[bloodGroup] || 0;

            if (quantity > available) {
                alert(`Only ${available} units of ${bloodGroup} blood available. Please adjust your request or choose a compatible type.`);
                document.getElementById('blood_quantity').classList.add('is-invalid');
            } else {
                document.getElementById('blood_quantity').classList.remove('is-invalid');
            }
        }

        function validateForm() {
            const bloodGroupSelect = document.getElementById('blood_group');
            const selectedOption = bloodGroupSelect.options[bloodGroupSelect.selectedIndex];
            const isRare = selectedOption.getAttribute('data-is-rare') === 'true';
            const requestType = document.getElementById('request_type').value;

            if (requestType === 'Rare' && !isRare) {
                alert('You can only select Rare request type for AB-, B-, or A- blood types.');
                return false;
            }

            // Final stock validation
            const selectedGroup = bloodGroupSelect.value;
            const quantity = parseInt(document.getElementById('blood_quantity').value);
            if (quantity > (stock[selectedGroup] || 0)) {
                alert(`Insufficient stock for ${selectedGroup}.`);
                return false;
            }

            return true;
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            handleBloodGroupChange();

            document.getElementById('blood_group').addEventListener('change', handleBloodGroupChange);
        });
    </script>

@endsection
