@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span><i class="bi bi-people-fill"></i> {{ __('User Management') }}</span>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left"></i> {{ __('Back to Dashboard') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="mb-1">System Users</h5>
                            <p class="text-muted mb-0">Showing all {{ $users->count() }} users in the system</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-filter"></i> Filter
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-download"></i> Export
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Registered</th>
                                    <th scope="col">Bookings</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-{{ $user->isAdmin() ? 'danger' : 'info' }} text-white rounded-circle me-2 d-flex align-items-center justify-content-center" 
                                                    style="width: 32px; height: 32px; font-size: 14px;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $user->name }}</strong>
                                                    @if($user->id === Auth::id())
                                                        <span class="badge bg-secondary ms-1">You</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'info' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $user->bookings_count > 0 ? 'success' : 'secondary' }} rounded-pill">
                                                {{ $user->bookings_count }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                
                                                @if(!$user->isAdmin() && $user->id !== Auth::id())
                                                    <form action="{{ route('admin.users.toggle-role', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-warning" 
                                                            onclick="return confirm('Are you sure you want to make {{ $user->name }} an admin?')">
                                                            <i class="bi bi-person-fill-up"></i> Make Admin
                                                        </button>
                                                    </form>
                                                @elseif($user->isAdmin() && $user->id !== Auth::id())
                                                    <form action="{{ route('admin.users.toggle-role', $user->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-secondary" 
                                                            onclick="return confirm('Are you sure you want to remove admin privileges from {{ $user->name }}?')">
                                                            <i class="bi bi-person-fill-down"></i> Remove Admin
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                @if($user->id !== Auth::id())
                                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete {{ $user->name }}? This will also delete all their bookings and cannot be undone.');" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                            <i class="bi bi-trash"></i> Delete User
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">User Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Total Users</h6>
                                    <h3>{{ $users->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Administrators</h6>
                                    <h3 class="text-danger">{{ $users->where('role', 'admin')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Regular Users</h6>
                                    <h3 class="text-info">{{ $users->where('role', 'user')->count() }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted mb-2">Total Bookings</h6>
                                    <h3 class="text-success">{{ $users->sum('bookings_count') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 