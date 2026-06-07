@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Details</h5>
                    <div>
                        <a href="{{ route('users.edit', $user->user_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary btn-sm">Back</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">User ID:</div>
                        <div class="col-md-8">{{ $user->user_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Role:</div>
                        <div class="col-md-8">
                            <span class="badge bg-info">{{ $role->role_name ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Full Name:</div>
                        <div class="col-md-8">{{ $user->full_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Username:</div>
                        <div class="col-md-8">{{ $user->username }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Phone:</div>
                        <div class="col-md-8">{{ $user->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            @if($user->status == 'Active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection