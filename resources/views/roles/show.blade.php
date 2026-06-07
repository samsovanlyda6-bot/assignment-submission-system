@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Role Details</h5>
                    <a href="{{ route('roles.index') }}" class="btn btn-secondary btn-sm">Back</a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Role ID:</div>
                        <div class="col-md-9">{{ $role->role_id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Role Name:</div>
                        <div class="col-md-9">
                            <span class="badge bg-{{ $role->role_name == 'Admin' ? 'danger' : ($role->role_name == 'Teacher' ? 'primary' : 'info') }}">
                                {{ $role->role_name }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Created At:</div>
                        <div class="col-md-9">{{ $role->created_at ? $role->created_at->format('d/m/Y H:i') : 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Last Updated:</div>
                        <div class="col-md-9">{{ $role->updated_at ? $role->updated_at->format('d/m/Y H:i') : 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection