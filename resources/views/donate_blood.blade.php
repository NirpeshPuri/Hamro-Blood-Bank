@extends('layouts.donor_master')
@section('title', 'Blood Donation')
@section('content')

    <style>
        .donation-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .page-title {
            color: #ff4757;
            margin-bottom: 20px;
        }

        .action-btn {
            background-color: #ff4757;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .action-btn:hover {
            background-color: #ff6b6b;
            transform: translateY(-2px);
        }

        .action-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .results-panel {
            margin-top: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 100%;
            display: none;
        }

        .admin-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .admin-item {
            background-color: #f8f9fa;
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .admin-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .select-btn {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .donation-form-container {
            margin-top: 30px;
            width: 100%;
            display: none;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .label-cell {
            font-weight: 500;
            background-color: #f8f9fa;
            width: 30%;
        }

        .form-input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .submit-btn {
            background-color: #28a745;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
        }

        @media (max-width: 768px) {
            .admin-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .select-btn {
                margin-top: 10px;
                width: 100%;
            }
        }
    </style>

    <div class="donation-container">
        <h1 class="page-title">Blood Donation Request</h1>
        <button id="findAdminsBtn" class="action-btn">
            <span id="findBtnText">Find Nearby Blood Banks</span>
            <span id="findBtnLoading" class="loading" style="display: none;"></span>
        </button>

        <div id="adminResults" class="results-panel">
            <h2>Nearby Blood Banks</h2>
            <div id="noResults" class="no-results" style="display: none;">
                No blood banks found within 50km radius.
            </div>
            <ul id="adminList" class="admin-list"></ul>
        </div>

        <div id="donationFormContainer" class="donation-form-container">
            <h2>Donation Details</h2>
            <form id="donationForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="adminId" name="admin_id">

                <table class="form-table">
                    <tr>
                        <td class="label-cell"><label>Name:</label></td>
                        <td><input type="text" class="form-input" name="user_name" value="{{ auth()->user()->name }}" readonly></td>
                    </tr>
                    <tr>
                        <td class="label-cell"><label>Email:</label></td>
                        <td><input type="text" class="form-input" name="email" value="{{ auth()->user()->email }}" readonly></td>
                    </tr>
                    <tr>
                        <td class="label-cell"><label>Phone:</label></td>
                        <td><input type="text" class="form-input" name="phone" value="{{ auth()->user()->phone }}" readonly></td>
                    </tr>
                    <tr>
                        <td class="label-cell"><label>Blood Type:</label></td>
                        <td>
                            <input type="text" class="form-input" name="blood_type"
                                   value="{{ auth()->user()->blood_type }}" readonly>
                            <input type="hidden" name="blood_type" value="{{ auth()->user()->blood_type }}">
                        </td>
                    </tr>
                        <td class="label-cell"><label>Units Needed:</label></td>
                        <td><input type="number" class="form-input" name="blood_quantity" min="1" max="10" required></td>
                    </tr>
                    <tr>
                        <td class="label-cell"><label>Medical Form:</label></td>
                        <td>
                            <input type="file" class="form-input" name="request_form" accept=".jpeg,.png,.pdf" required>
                            <small>Accepted formats: JPEG, PNG, PDF (Max 2MB)</small>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" id="submitDonation" class="submit-btn">
                                <span id="submitBtnText">Submit Request</span>
                                <span id="submitBtnLoading" class="loading" style="display: none;"></span>
                            </button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <
    <script>
        $(document).ready(function() {
            // Find nearby blood banks
            $('#findAdminsBtn').click(function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        $.ajax({
                            url: "{{ route('donate.blood.find-nearby') }}",
                            type: "POST",
                            data: {
                                latitude: latitude,
                                longitude: longitude,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                $('#adminResults').show();
                                $('#adminList').empty();

                                response.forEach(function(admin) {
                                    const listItem = $(
                                        `<li class="admin-item">
                                        ${admin.name} (${admin.distance.toFixed(2)} km)
                                        <button class="select-btn" data-admin-id="${admin.id}">Select</button>
                                    </li>`
                                    );
                                    $('#adminList').append(listItem);
                                });

                                // Add click handler to all select buttons
                                $('.select-btn').click(function() {
                                    const adminId = $(this).data('admin-id');
                                    selectAdmin(adminId);
                                });
                            },
                            error: function(xhr) {
                                console.error('AJAX error:', xhr.responseText);
                                alert('Failed to find nearby blood banks');
                            }
                        });
                    }, function(error) {
                        console.error('Geolocation error:', error.message);
                        alert('Error getting location: ' + error.message);
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });

            // Select a blood bank
            function selectAdmin(adminId) {
                $('#adminId').val(adminId);
                $('#donationFormContainer').show();
                $('html, body').animate({
                    scrollTop: $('#donationFormContainer').offset().top - 20
                }, 500);
            }

            // Handle form submission
            $('#donationForm').submit(function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ route('donate.blood.request') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert(response.message);
                        $('#donationForm')[0].reset();
                        $('#donationFormContainer').hide();
                    },
                    error: function(xhr) {
                        console.error('Submission error:', xhr.responseText);
                        alert('Failed to submit donation request');
                    }
                });
            });
        });
    </script>
@endsection
