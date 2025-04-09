@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fs-5"><i class="bi bi-list-check me-2"></i>{{ __('Services Management') }}</span>
                        <div>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-secondary me-2">{{ __('Back to Dashboard') }}</a>
                            <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-primary">{{ __('Add New Service') }}</a>
                        </div>
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
                        @foreach($services as $service)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 service-card">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">{{ $service->name }}</h5>
                                        <span class="badge bg-success">₱{{ number_format($service->price, 2) }}</span>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ Str::limit($service->description, 100) }}</p>
                                        <div class="d-flex justify-content-between">
                                            <span class="badge bg-info">{{ $service->duration }} minutes</span>
                                            <span class="badge bg-secondary">{{ $service->bookings_count }} bookings</span>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            
                                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header">{{ __('Services Analytics') }}</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Most Popular Services</h5>
                                    <div class="list-group mt-3">
                                        @forelse($services->sortByDesc('bookings_count')->take(3) as $service)
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $service->name }}
                                                <span class="badge bg-primary rounded-pill">
                                                    {{ $service->bookings_count }} bookings
                                                </span>
                                            </div>
                                        @empty
                                            <div class="list-group-item">No bookings data available</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Price Range</h5>
                                    <div class="list-group mt-3">
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            Lowest Price
                                            <span class="badge bg-success rounded-pill">
                                                ₱{{ number_format($services->min('price'), 2) }}
                                            </span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            Highest Price
                                            <span class="badge bg-success rounded-pill">
                                                ₱{{ number_format($services->max('price'), 2) }}
                                            </span>
                                        </div>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            Average Price
                                            <span class="badge bg-success rounded-pill">
                                                ₱{{ number_format($services->avg('price'), 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .service-card {
        transition: transform 0.2s;
    }
    .service-card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection 