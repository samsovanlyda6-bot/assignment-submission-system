@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Roles Management</h5>
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Add New Role</a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                <tr>
                                    <td>{{ $role->role_id }}</td>
                                    <td>
                                        <span class="badge bg-{{ $role->role_name == 'Admin' ? 'danger' : ($role->role_name == 'Teacher' ? 'primary' : 'info') }}">
                                            {{ $role->role_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('roles.show', $role->role_id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('roles.edit', $role->role_id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('roles.destroy', $role->role_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this role?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No roles found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-3">
                        {{ $roles->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection