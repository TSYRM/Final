@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Service Details') }}</span>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-secondary">{{ __('Back to Services') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h3>{{ $service->name }}</h3>
                        <span class="badge bg-success fs-6 my-2">₱{{ number_format($service->price, 2) }}</span>
                        <div class="d-flex justify-content-center gap-3 mt-2">
                            <span class="badge bg-info">{{ $service->duration }} minutes</span>
                            <span class="badge bg-secondary">{{ $service->bookings_count ?? $service->bookings()->count() }} bookings</span>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0">Description</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0">{{ $service->description }}</p>
                        </div>
                    </div>

                    @if(Auth::user()->isAdmin())
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> {{ __('Edit Service') }}
                            </a>
                            
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this service? This action cannot be undone.')">
                                    <i class="bi bi-trash"></i> Delete Service
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center">
                            <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                                Book This Service
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            @if(Auth::user()->isAdmin() && isset($service->bookings_count) && $service->bookings_count > 0)
                <div class="card mt-4">
                    <div class="card-header">Booking Statistics</div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Pending</h5>
                                        <h3 class="text-warning">
                                            {{ $service->bookings()->where('status', 'pending')->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Confirmed</h5>
                                        <h3 class="text-success">
                                            {{ $service->bookings()->where('status', 'confirmed')->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5 class="card-title">Cancelled</h5>
                                        <h3 class="text-danger">
                                            {{ $service->bookings()->where('status', 'cancelled')->count() }}
                                        </h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 