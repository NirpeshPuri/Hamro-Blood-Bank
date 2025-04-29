@extends('layouts.receiver_master')
@section('title', 'Search Blood')
@section('content')
    <style>
        /* Main Container Styles */
        .center-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Blood Bank List Styles */
        #nearbyAdmins {
            margin-top: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        #adminList {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        #adminList li {
            background-color: #f8f9fa;
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        #adminList li:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        #adminList li button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #adminList li button:hover {
            background-color: #218838;
        }

        /* Form Container Styles */
        .form-container {
            display: flex;
            width: 100%;
            gap: 20px;
            margin-top: 20px;
        }

        /* Stock Display Styles */
        .stock-display {
            flex: 1;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .stock-table th,
        .stock-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }

        .stock-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* Style for different stock levels */
        .text-danger { color: #dc3545; font-weight: bold; }
        .text-warning { color: #ffc107; font-weight: bold; }

        /* Form Styles */
        #requestForm {
            flex: 2;
            display: none;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        #requestForm table {
            width: 100%;
            border-collapse: collapse;
        }

        #requestForm table td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        #requestForm table td:first-child {
            width: 40%;
            font-weight: 500;
        }

        #requestForm input[type="text"],
        #requestForm input[type="email"],
        #requestForm input[type="tel"],
        #requestForm select,
        #requestForm input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        #requestForm input[type="text"]:disabled,
        #requestForm input[type="email"]:disabled,
        #requestForm input[type="tel"]:disabled {
            background-color: #f8f9fa;
            color: #666;
        }

        #requestForm input[type="file"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: white;
        }

        /* Button Styles */
        #submitRequest {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #submitRequest:hover {
            background-color: #218838;
        }

        #findNearbyAdmins {
            background-color: #ff4757;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #findNearbyAdmins:hover {
            background-color: #ff6b6b;
        }

        #changeAdmin {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #changeAdmin:hover {
            background-color: #5a6268;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
            }

            .stock-display, #requestForm {
                width: 100%;
            }

            #requestForm table td {
                display: block;
                width: 100%;
                padding: 8px 0;
                border-bottom: none;
            }

            #requestForm table td:first-child {
                width: 100%;
                padding-bottom: 5px;
            }
        }
    </style>

    <div class="center-container">
        <h1>Search for Blood</h1>
        <button id="findNearbyAdmins">Find Nearby Blood Banks</button>

        <!-- List of nearby admins -->
        <div id="nearbyAdmins" style="display: none;">
            <h2>Nearby Blood Banks</h2>
            <button id="changeAdmin" style="display: none; margin-bottom: 10px;">Change Blood Bank</button>
            <ul id="adminList"></ul>
        </div>

        <!-- Form container with stock display and request form -->
        <div class="form-container">
            <!-- Blood stock display (left side) -->
            <div class="stock-display" id="stockDisplay" style="display: none;">
                <h3>Available Blood Stock</h3>
                <table class="stock-table">
                    <thead>
                    <tr>
                        <th>Blood Type</th>
                        <th>Units Available</th>
                    </tr>
                    </thead>
                    <tbody id="stockTableBody">
                    <!-- Will be populated by JavaScript -->
                    </tbody>
                </table>
                <div style="margin-top: 15px; font-size: 0.9rem; color: #666;">
                    <span class="text-danger">■</span> Out of stock &nbsp;
                    <span class="text-warning">■</span> Low stock
                </div>
            </div>

            <!-- Your exact form (right side) -->
            <div id="requestForm">
                <h2>Submit Request</h2>
                <form id="submitRequestForm" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="adminId" name="admin_id">
                    <input type="hidden" id="userId" name="user_id" value="{{ auth()->user()->id }}">

                    <table>
                        <tr>
                            <td><label>Blood Bank:</label></td>
                            <td><input type="text" id="adminNameDisplay" disabled></td>
                        </tr>
                        <tr>
                            <td><label for="user_name">Name:</label></td>
                            <td><input type="text" id="user_name" name="user_name" value="{{ auth()->user()->name }}" disabled></td>
                        </tr>
                        <tr>
                            <td><label for="user_email">Email:</label></td>
                            <td><input type="email" id="user_email" name="user_email" value="{{ auth()->user()->email }}" disabled></td>
                        </tr>
                        <tr>
                            <td><label for="user_phone">Phone:</label></td>
                            <td><input type="text" id="user_phone" name="user_phone" value="{{ auth()->user()->phone }}" disabled></td>
                        </tr>
                        <!-- In your form section -->
                        <tr>
                            <td><label for="blood_group">Blood Group:</label></td>
                            <td>
                                <select id="blood_group" name="blood_group" required onchange="checkBloodType()">
                                    @php
                                        $userBloodType = auth()->user()->blood_type;
                                        // Define rare blood types
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

                                        $allowedTypes = $compatibleTypes[$userBloodType] ?? [
                                            'A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'
                                        ];
                                    @endphp

                                    @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                                        @if(in_array($type, $allowedTypes))
                                            <option value="{{ $type }}"
                                                    {{ $type == $userBloodType ? 'selected' : '' }}
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
                                        Please set your blood type in your profile....
                                    @endif
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="blood_quantity">Blood Quantity (Units):</label></td>
                            <td>
                                <input type="number" id="blood_quantity" name="blood_quantity" min="1" max="5" required>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="request_type">Request Type:</label></td>
                            <td>
                                <select id="request_type" name="request_type" required>
                                    <option value="Emergency">Emergency</option>
                                    <option value="Rare" id="rareOption" disabled>Rare (select rare blood type first)</option>
                                    <option value="Normal" selected>Normal</option>
                                </select>
                                <small class="text-muted">
                                        Rare Blood Type are (AB-, B-, A-)
                                </small>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="payment">Payment Amount (NPR):</label></td>
                            <td>
                                <input type="number" id="payment" name="payment" min="0" max="1500" step="0.01" required>
                            </td>
                        </tr>
                        <tr>
                            <td><label for="request_form">Upload Hospital Form (Proof):</label></td>
                            <td><input type="file" id="request_form" name="request_form" accept="image/*" required></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit" id="submitRequest">Submit Request</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Find nearby admins
            $('#findNearbyAdmins').click(function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        $.ajax({
                            url: "{{ route('find.nearby.admins') }}",
                            type: "POST",
                            data: {
                                latitude: position.coords.latitude,
                                longitude: position.coords.longitude,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('#nearbyAdmins').show();
                                $('#adminList').empty();
                                response.forEach(function(admin) {
                                    $('#adminList').append(
                                        `<li>
                                    ${admin.name} (${admin.distance.toFixed(2)} km)
                                    <button onclick="selectAdmin(${admin.id}, '${admin.name.replace(/'/g, "\\'")}')">
                                        Select
                                    </button>
                                </li>`
                                    );
                                });
                            }
                        });
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });

            // Function to select an admin and show their blood stock
            window.selectAdmin = function(adminId, adminName) {
                $('#adminId').val(adminId);
                $('#adminNameDisplay').val(adminName);

                // Fetch blood stock directly from blood_banks table
                $.ajax({
                    url: `/blood-banks/${adminId}/stock`,
                    type: "GET",
                    success: function(stockData) {
                        // Populate the stock table
                        const stockTableBody = $('#stockTableBody');
                        stockTableBody.empty();

                        // Define all blood types
                        const bloodTypes = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'];

                        // Create table rows for each blood type
                        bloodTypes.forEach(type => {
                            const quantity = stockData[type] || 0;
                            const rowClass = quantity === 0 ? 'text-danger' : (quantity < 10 ? 'text-warning' : '');

                            stockTableBody.append(
                                `<tr>
                            <td class="${rowClass}">${type}</td>
                            <td class="${rowClass}">${quantity} units</td>
                        </tr>`
                            );
                        });

                        // Show the stock display and form
                        $('#stockDisplay').show();
                        $('#requestForm').show();
                        $('#changeAdmin').show();
                    },
                    error: function() {
                        alert('Failed to load blood stock information');
                    }
                });
            };

            // Change admin button
            $('#changeAdmin').click(function() {
                $('#stockDisplay').hide();
                $('#requestForm').hide();
                $(this).hide();
            });

            // Form submission
            $('#submitRequestForm').on('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                $.ajax({
                    url: "{{ route('submit.blood.request') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Blood request submitted successfully!');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert('Error: ' + (xhr.responseJSON?.message || 'Request failed'));
                    }
                });
            });
        });




        function checkBloodType() {
            const bloodGroupSelect = document.getElementById('blood_group');
            const selectedOption = bloodGroupSelect.options[bloodGroupSelect.selectedIndex];
            const isRare = selectedOption.getAttribute('data-is-rare') === 'true';
            const rareOption = document.getElementById('rareOption');
            const requestTypeSelect = document.getElementById('request_type');

            if (isRare) {
                // Enable the Rare option
                rareOption.disabled = false;
                rareOption.textContent = 'Rare';

                // If current selection is disabled, switch to Normal
                if (requestTypeSelect.value === 'Rare' && rareOption.disabled) {
                    requestTypeSelect.value = 'Normal';
                }
            } else {
                // Disable Rare option and switch to Normal if currently selected
                rareOption.disabled = true;
                if (requestTypeSelect.value === 'Rare') {
                    requestTypeSelect.value = 'Normal';
                }
            }
        }

        // Initialize on page load and whenever blood group changes
        document.addEventListener('DOMContentLoaded', function() {
            checkBloodType();

            // Also check when blood group changes
            document.getElementById('blood_group').addEventListener('change', checkBloodType);
        });
    </script>
@endsection
