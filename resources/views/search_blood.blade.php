@extends('layouts.receiver_master')
@section('title', 'Search Blood')
@section('content')
    <style>
        .center-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #ff4757;
            margin-bottom: 20px;
        }

        button {
            background-color: #ff4757;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        button:hover {
            background-color: #ff6b6b;
            transform: translateY(-2px);
        }

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

        #requestForm table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #requestForm table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        #requestForm table td:first-child {
            font-weight: 500;
            background-color: #f8f9fa;
            width: 30%;
        }

        #requestForm table input[type="text"],
        #requestForm table input[type="email"],
        #requestForm table input[type="tel"],
        #requestForm table select,
        #requestForm table input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        #requestForm table input[type="text"]:disabled,
        #requestForm table input[type="email"]:disabled,
        #requestForm table input[type="tel"]:disabled {
            background-color: #f8f9fa;
            color: #666;
        }

        #requestForm table input[type="file"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            background-color: white;
        }

        #requestForm table button[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #requestForm table button[type="submit"]:hover {
            background-color: #218838;
        }

        #requestForm table button[type="button"] {
            background-color: #ff4757;
            color: white;
            border: none;
            padding: 10px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #requestForm table button[type="button"]:hover {
            background-color: #ff6b6b;
        }

        @media (max-width: 768px) {
            #adminList li {
                flex-direction: column;
                align-items: flex-start;
            }

            #adminList li button {
                margin-top: 10px;
                width: 100%;
            }
        }
        /* Add these to your existing styles */
        #changeAdmin {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #changeAdmin:hover {
            background-color: #5a6268;
        }

        #nearbyAdmins {
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        #adminList li button {
            margin-left: 10px;
        }
    </style>

    <div class="center-container">
        <h1>Search for Blood</h1>
        <button id="findNearbyAdmins">Find Nearby Blood Banks</button>

        <!-- List of nearby admins (now always visible after first search) -->
        <div id="nearbyAdmins" style="display: none;">
            <h2>Nearby Blood Banks</h2>
            <button id="changeAdmin" style="display: none; margin-bottom: 10px;"
                    class="btn btn-secondary">Change Blood Bank</button>
            <ul id="adminList"></ul>
        </div>

        <!-- Form to submit request -->
        <div id="requestForm" style="display: none;">
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

                    <!-- Blood Group Selection -->
                    <tr>
                        <td><label for="blood_group">Blood Group:</label></td>
                        <td>
                            <select id="blood_group" name="blood_group" required>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </td>
                    </tr>

                    <!-- Blood Quantity -->
                    <tr>
                        <td><label for="blood_quantity">Blood Quantity (Units):</label></td>
                        <td>
                            <input type="number" id="blood_quantity" name="blood_quantity" min="1" required>
                        </td>
                    </tr>

                    <!-- Request Type -->
                    <tr>
                        <td><label for="request_type">Request Type:</label></td>
                        <td>
                            <select id="request_type" name="request_type" required>
                                <option value="Emergency">Emergency</option>
                                <option value="Rare">Rare</option>
                                <option value="Normal">Normal</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="payment">Payment Amount (NPR):</label></td>
                        <td>
                            <input type="number" id="payment" name="payment" min="0" step="0.01" required>
                        </td>
                    </tr>

                    <!-- Hospital Form Upload -->
                    <tr>
                        <td><label for="request_form">Upload Hospital Form (Proof):</label></td>
                        <td><input type="file" id="request_form" name="request_form" accept="image/*" required></td>
                    </tr>

                    <!-- Submit Button -->
                    <tr>
                        <td colspan="2">
                            <button type="submit" id="submitRequest">Submit Request</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Find nearby admins
        $('#findNearbyAdmins').click(function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    $.ajax({
                        url: "{{ route('find.nearby.admins') }}",
                        type: "POST",
                        data: {
                            latitude: latitude,
                            longitude: longitude,
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

        // Function to select an admin
        function selectAdmin(adminId, adminName) {
            $('#adminId').val(adminId);
            $('#adminNameDisplay').val(adminName);
            $('#requestForm').show();
            $('#changeAdmin').show();
        }

        // Change admin button
        $('#changeAdmin').click(function() {
            $('#requestForm').hide();
            $(this).hide();
        });

        // Form submission remains the same
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
                }
            });
        });
    </script>
@endsection



