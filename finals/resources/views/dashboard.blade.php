@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>{{ __('Dashboard') }}</span>
                    @if(!Auth::user()->isAdmin())
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary btn-sm">{{ __('Book New Appointment') }}</a>
                    @else
                        <a href="{{ route('admin.services.create') }}" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle"></i> {{ __('Add New Service') }}
                        </a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h4>Welcome, {{ Auth::user()->name }}!</h4>
                    <p>{{ Auth::user()->isAdmin() ? 'You are logged in as an administrator.' : 'You are logged in as a customer.' }}</p>
                    
                    <h5 class="mt-4">{{ Auth::user()->isAdmin() ? 'All Bookings' : 'Your Bookings' }}</h5>
                    
                    @if(count($bookings) > 0)
                        <div class="table-responsive mt-3">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        @if(Auth::user()->isAdmin())
                                            <th>Customer</th>
                                        @endif
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->id }}</td>
                                            @if(Auth::user()->isAdmin())
                                                <td>{{ $booking->user->name }}</td>
                                            @endif
                                            <td>{{ $booking->service->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
                                                    
                                                    @if((!Auth::user()->isAdmin() || Auth::user()->isAdmin()) && $booking->status !== 'cancelled')
                                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    @endif
                                                    
                                                    @if(!Auth::user()->isAdmin() && $booking->status !== 'cancelled')
                                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">Cancel</button>
                                                        </form>
                                                    @endif
                                                    
                                                    @if(Auth::user()->isAdmin())
                                                        <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            @if($booking->status === 'pending')
                                                                <input type="hidden" name="status" value="confirmed">
                                                                <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                                            @elseif($booking->status === 'confirmed')
                                                                <input type="hidden" name="status" value="cancelled">
                                                                <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                                                            @endif
                                                        </form>
                                                        
                                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('Are you sure you want to permanently delete this booking? This action cannot be undone.')">
                                                                <i class="bi bi-trash"></i> Delete
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
                    @else
                        <div class="alert alert-info mt-3">
                            {{ Auth::user()->isAdmin() ? 'No bookings found in the system.' : 'You have no bookings yet.' }}
                        </div>
                    @endif
                    
                    @if(Auth::user()->isAdmin())
                        <div class="mt-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0">{{ __('All Users') }}</h5>
                                <div>
                                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-gear-fill"></i> {{ __('Advanced User Management') }}
                                    </a>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Bookings</th>
                                            <th>Actions</th>
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
                                                            {{ $user->name }}
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
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="bi bi-trash"></i> Delete
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 