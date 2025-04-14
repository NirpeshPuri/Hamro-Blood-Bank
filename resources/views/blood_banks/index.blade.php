<!-- resources/views/blood_banks/index.blade.php -->

@extends('layouts.admin_master')
@section('title', 'Blood Banks')
@section('content')

    <div class="container">
        <h1>Blood Banks</h1>
        <a href="{{ route('blood-banks.create') }}" class="btn btn-primary mb-3">Create New Blood Bank</a>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Admin</th>
                <th>Blood Types</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($bloodBanks as $bloodBank)
                <tr>
                    <td>{{ $bloodBank->id }}</td>
                    <td>{{ $bloodBank->admin_name }}</td>
                    <td>
                        @foreach(['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $type)
                            @if($bloodBank->$type > 0)
                                <span class="badge bg-danger">{{ $type }}: {{ $bloodBank->$type }}</span>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('blood-banks.show', $bloodBank) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('blood-banks.edit', $bloodBank) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('blood-banks.update-stock-form', $bloodBank) }}" class="btn btn-secondary btn-sm">Update Stock</a>
                        <form action="{{ route('blood-banks.destroy', $bloodBank) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
