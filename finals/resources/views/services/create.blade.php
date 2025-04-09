@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>{{ __('Create New Service') }}</span>
                        <a href="{{ route('admin.services.index') }}" class="btn btn-sm btn-secondary">{{ __('Back to Services') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.services.store') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Service Name') }} <span class="text-danger">*</span></label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" 
                                name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="price" class="form-label">{{ __('Price (₱)') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" 
                                        name="price" value="{{ old('price') }}" min="0" step="0.01" required>
                                </div>
                                @error('price')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label for="duration" class="form-label">{{ __('Duration (minutes)') }} <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" 
                                        name="duration" value="{{ old('duration') }}" min="15" step="5" required>
                                    <span class="input-group-text">minutes</span>
                                </div>
                                @error('duration')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Add Service') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 