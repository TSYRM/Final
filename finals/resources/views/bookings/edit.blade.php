@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Edit Booking') }}</span>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">{{ __('Back to Dashboard') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('bookings.update', $booking->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="service_id" class="form-label fw-bold">{{ __('Select Service') }}</label>
                            <div class="row g-3">
                                @foreach($services as $service)
                                    <div class="col-md-6">
                                        <div class="card h-100 service-card @if(old('service_id', $booking->service_id) == $service->id) border-primary @endif">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="service_id" 
                                                        id="service_{{ $service->id }}" value="{{ $service->id }}"
                                                        {{ old('service_id', $booking->service_id) == $service->id ? 'checked' : '' }} required>
                                                    <label class="form-check-label fw-bold" for="service_{{ $service->id }}">
                                                        {{ $service->name }}
                                                    </label>
                                                </div>
                                                <p class="ms-4 text-muted small mt-1">{{ $service->description }}</p>
                                                <div class="ms-4 d-flex justify-content-between">
                                                    <span class="badge bg-success">₱{{ number_format($service->price, 2) }}</span>
                                                    <span class="badge bg-info">{{ $service->duration }} mins</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('service_id')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="appointment_date" class="form-label">{{ __('Appointment Date') }}</label>
                                <input id="appointment_date" type="date" class="form-control @error('appointment_date') is-invalid @enderror" 
                                    name="appointment_date" value="{{ old('appointment_date', $booking->appointment_date) }}" required min="{{ date('Y-m-d') }}">
                                @error('appointment_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="appointment_time" class="form-label">{{ __('Appointment Time') }}</label>
                                <select id="appointment_time" class="form-select @error('appointment_time') is-invalid @enderror" 
                                    name="appointment_time" required>
                                    <option value="" disabled>Select time</option>
                                    @foreach(['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                        <option value="{{ $time }}" {{ old('appointment_time', substr($booking->appointment_time, 0, 5)) == $time ? 'selected' : '' }}>
                                            {{ date('g:i A', strtotime($time)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('appointment_time')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="notes" class="form-label">{{ __('Special Requests or Notes') }}</label>
                            <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                name="notes" rows="3">{{ old('notes', $booking->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        @if(!Auth::user()->isAdmin())
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Note: Editing your booking will reset its status to "pending" and require admin approval again.
                        </div>
                        @else
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            As an admin, you can edit this booking without changing its approval status.
                        </div>
                        @endif
                        
                        <div class="mb-0 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Booking') }}
                            </button>
                            
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .service-card {
        cursor: pointer;
        transition: all 0.2s;
    }
    .service-card:hover {
        border-color: #0d6efd;
        transform: translateY(-3px);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Make entire card clickable for service selection
        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('input[type="radio"]');
                radio.checked = true;
                
                // Remove border from all cards and add to selected
                serviceCards.forEach(c => c.classList.remove('border-primary'));
                this.classList.add('border-primary');
            });
        });
    });
</script>
@endsection 