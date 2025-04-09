@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Book New Appointment') }}</span>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary">{{ __('Back to Dashboard') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('bookings.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="service_id" class="form-label fw-bold">{{ __('Select Service') }}</label>
                            <div class="row g-3">
                                @foreach($services as $service)
                                    <div class="col-md-6">
                                        <div class="card h-100 service-card @if(old('service_id') == $service->id) border-primary @endif">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="service_id" 
                                                        id="service_{{ $service->id }}" value="{{ $service->id }}"
                                                        {{ old('service_id') == $service->id ? 'checked' : '' }} required>
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
                                    name="appointment_date" value="{{ old('appointment_date') }}" required min="{{ date('Y-m-d') }}">
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
                                    <option value="" disabled {{ old('appointment_time') ? '' : 'selected' }}>Select time</option>
                                    @foreach(['09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00', '17:00'] as $time)
                                        <option value="{{ $time }}" {{ old('appointment_time') == $time ? 'selected' : '' }}>
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
                                name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-0">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Book Appointment') }}
                            </button>
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