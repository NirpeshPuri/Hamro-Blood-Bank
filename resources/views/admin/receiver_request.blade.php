@extends('layouts.admin_master')
@section('title', 'Receiver Request')
@section('content')

        <div class="container">
            <!-- Blood Bank Inventory -->
            <div class="mb-4">
                <h4>Blood Bank Inventory</h4>
                <div class="row">
                    @foreach(BloodBank::bloodGroups() as $group)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ $group }}</h5>
                                    <p class="card-text h4">
                                        {{ auth()->user()->bloodBank ? auth()->user()->bloodBank->getBloodGroupQuantity($group) : 0 }}
                                        <small class="text-muted">units</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <h2>Receiver Blood Requests</h2>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>User Name</th>
                        <th>Contact</th>
                        <th>Blood Group</th>
                        <th>Quantity</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($requests as $request)
                        <tr>
                            <td>{{ $request->user_name }}</td>
                            <td>
                                {{ $request->email }}<br>
                                {{ $request->phone }}
                            </td>
                            <td>{{ $request->blood_group }}</td>
                            <td>{{ $request->blood_quantity }}</td>
                            <td>{{ $request->request_type }}</td>
                            <td>
                        <span class="badge badge-{{
                            $request->status == 'Approved' ? 'success' :
                            ($request->status == 'Rejected' ? 'danger' : 'warning')
                        }}">
                            {{ $request->status }}
                        </span>
                            </td>
                            <td>{{ $request->payment ? '$'.number_format($request->payment, 2) : 'N/A' }}</td>
                            <td>{{ $request->created_at->format('d M Y') }}</td>
                            <td>
                                <form action="{{ route('admin.receiver.update-status', $request->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-2">
                                        <select name="status" class="form-control form-control-sm">
                                            <option value="Approved" {{ $request->status == 'Approved' ? 'selected' : '' }}>Approve</option>
                                            <option value="Rejected" {{ $request->status == 'Rejected' ? 'selected' : '' }}>Reject</option>
                                            <option value="Pending" {{ $request->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-2">
                                        <input type="number" name="payment" class="form-control form-control-sm"
                                               placeholder="Amount" value="{{ $request->payment }}" step="0.01">
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary btn-block">Update</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No requests found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

@endsection
