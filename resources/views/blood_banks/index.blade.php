@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Blood Banks</h4>
                    <a href="{{ route('blood-banks.create') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Add New
                    </a>
                </div>
            </div>

            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Admin ID</th>
                            <th>Admin Name</th>
                            <th>Blood Availability</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($bloodBanks as $bank)
                            <tr>
                                <td>{{ $bank->id }}</td>
                                <td>{{ $bank->admin_id }}</td>
                                <td>{{ $bank->admin_name }}</td>
                                <td>
                                    <div class="blood-grid">
                                        @foreach($bank->blood_availability as $type => $units)
                                            <span class="badge {{ $units > 0 ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $type }}: {{ $units }}
                                        </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('blood-banks.show', $bank->id) }}"
                                       class="btn btn-sm btn-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('blood-banks.edit', $bank->id) }}"
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('blood-banks.destroy', $bank->id) }}"
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                title="Delete" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No blood banks found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .blood-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 5px;
        }
        .badge {
            font-size: 0.8rem;
            padding: 0.35em 0.65em;
            white-space: nowrap;
        }
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@endsection
