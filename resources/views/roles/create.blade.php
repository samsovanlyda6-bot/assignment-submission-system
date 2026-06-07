@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add New Role</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="role_name" class="form-label">Role Name *</label>
                            <input type="text" name="role_name" id="role_name" class="form-control @error('role_name') is-invalid @enderror" value="{{ old('role_name') }}" required>
                            <small class="text-muted">Possible values: Admin, Teacher, Student</small>
                            @error('role_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection