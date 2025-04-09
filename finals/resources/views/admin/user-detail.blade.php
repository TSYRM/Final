@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('User Details') }}</span>
                        <a href="{{ route('admin.users') }}" class="btn btn-sm btn-secondary">{{ __('Back to Users List') }}</a>
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">User Information</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="30%">ID:</th>
                                            <td>{{ $user->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Name:</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Role:</th>
                                            <td>
                                                <span class="badge bg-{{ $user->isAdmin() ? 'danger' : 'info' }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Registered:</th>
                                            <td>{{ $user->created_at->format('M d, Y g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Bookings:</th>
                                            <td>{{ $bookings->count() }}</td>
                                        </tr>
                                    </table>

                                    @if(!$user->isAdmin() && Auth::id() !== $user->id)
                                        <form action="{{ route('admin.users.toggle-role', $user->id) }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-warning" 
                                                onclick="return confirm('Are you sure you want to make this user an admin?')">
                                                Make Admin
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Activity</h5>
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <strong>First booking:</strong> 
                                            {{ $bookings->last() ? $bookings->last()->created_at->format('M d, Y') : 'N/A' }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Latest booking:</strong> 
                                            {{ $bookings->first() ? $bookings->first()->created_at->format('M d, Y') : 'N/A' }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Upcoming appointments:</strong> 
                                            {{ $bookings->where('appointment_date', '>=', now()->format('Y-m-d'))->where('status', '!=', 'cancelled')->count() }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Completed appointments:</strong>
                                            {{ $bookings->where('appointment_date', '<', now()->format('Y-m-d'))->where('status', 'confirmed')->count() }}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Cancelled appointments:</strong>
                                            {{ $bookings->where('status', 'cancelled')->count() }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-4">{{ __('Booking History') }}</h5>
                    @if(count($bookings) > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Service</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->id }}</td>
                                            <td>{{ $booking->service->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">View</a>
                                                    
                                                    @if($booking->status !== 'cancelled')
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
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            {{ __('This user has no bookings yet.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 