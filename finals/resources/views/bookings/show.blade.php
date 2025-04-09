@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Booking Details') }}</span>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">{{ __('Back to Dashboard') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-4 text-center">
                        <span class="badge bg-{{ $booking->status === 'confirmed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'danger') }} p-2">
                            <i class="bi bi-{{ $booking->status === 'confirmed' ? 'check-circle' : ($booking->status === 'pending' ? 'clock' : 'x-circle') }}"></i>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $booking->service->name }}</h5>
                                    <p class="card-text text-muted">{{ $booking->service->description }}</p>
                                    <div class="d-flex justify-content-between">
                                        <span class="badge bg-success">₱{{ number_format($booking->service->price, 2) }}</span>
                                        <span class="badge bg-info">{{ $booking->service->duration }} mins</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">{{ __('Appointment Date') }}</label>
                            <p class="lead">{{ \Carbon\Carbon::parse($booking->appointment_date)->format('M d, Y') }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">{{ __('Appointment Time') }}</label>
                            <p class="lead">{{ \Carbon\Carbon::parse($booking->appointment_time)->format('g:i A') }}</p>
                        </div>
                        
                        @if(Auth::user()->isAdmin())
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">{{ __('Customer') }}</label>
                            <p class="lead">{{ $booking->user->name }}</p>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">{{ __('Contact Email') }}</label>
                            <p class="lead">{{ $booking->user->email }}</p>
                        </div>
                        @endif
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted">{{ __('Special Requests or Notes') }}</label>
                            <p class="lead">{{ $booking->notes ?: 'No special requests' }}</p>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label class="form-label text-muted">{{ __('Booking ID') }}</label>
                            <p class="lead">#{{ $booking->id }}</p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mt-4">
                        @if($booking->status !== 'cancelled')
                            <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> {{ __('Edit Booking') }}
                            </a>
                            
                            @if(!Auth::user()->isAdmin())
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" 
                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        <i class="bi bi-x-circle"></i> {{ __('Cancel Booking') }}
                                    </button>
                                </form>
                            @endif
                        @else
                            <div class="alert alert-danger w-100 mb-0">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                This booking has been cancelled.
                            </div>
                        @endif
                    </div>
                    
                    @if(Auth::user()->isAdmin() && $booking->status !== 'cancelled')
                        <div class="mt-4">
                            <div class="d-flex justify-content-between">
                                @if($booking->status === 'pending')
                                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="w-100 me-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="confirmed">
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="bi bi-check-circle"></i> {{ __('Confirm Booking') }}
                                        </button>
                                    </form>
                                @endif
                                
                                @if($booking->status === 'confirmed')
                                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST" class="w-100 me-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="cancelled">
                                        <button type="submit" class="btn btn-danger w-100"
                                            onclick="return confirm('Are you sure you want to cancel this booking?')">
                                            <i class="bi bi-x-circle"></i> {{ __('Cancel Booking') }}
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="w-100 ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100" 
                                        onclick="return confirm('Are you sure you want to permanently delete this booking? This action cannot be undone.')">
                                        <i class="bi bi-trash"></i> {{ __('Delete Permanently') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 