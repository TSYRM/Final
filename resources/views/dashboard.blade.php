@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
                <p class="mt-2 text-gray-600">Welcome back, {{ Auth::user()->name }}!</p>
                
                <div class="mt-6">
                    <h2 class="text-lg font-medium text-gray-700">Quick Actions</h2>
                    
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <a href="{{ route('services.index') }}" class="block p-6 bg-indigo-50 rounded-lg border border-indigo-100 hover:bg-indigo-100 transition">
                            <h3 class="text-base font-medium text-indigo-700">View Services</h3>
                            <p class="mt-1 text-sm text-indigo-600">Browse available services</p>
                        </a>
                        
                        <a href="{{ route('bookings.create') }}" class="block p-6 bg-green-50 rounded-lg border border-green-100 hover:bg-green-100 transition">
                            <h3 class="text-base font-medium text-green-700">Book a Service</h3>
                            <p class="mt-1 text-sm text-green-600">Schedule a new booking</p>
                        </a>
                        
                        <a href="{{ route('bookings.index') }}" class="block p-6 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition">
                            <h3 class="text-base font-medium text-blue-700">My Bookings</h3>
                            <p class="mt-1 text-sm text-blue-600">View your booking history</p>
                        </a>
                    </div>
                </div>
                
                @if(Auth::user()->isAdmin())
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h2 class="text-lg font-medium text-gray-700">Admin Actions</h2>
                    
                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <a href="{{ route('services.create') }}" class="block p-6 bg-purple-50 rounded-lg border border-purple-100 hover:bg-purple-100 transition">
                            <h3 class="text-base font-medium text-purple-700">Add Service</h3>
                            <p class="mt-1 text-sm text-purple-600">Create a new service</p>
                        </a>
                        
                        <a href="{{ route('bookings.index') }}" class="block p-6 bg-yellow-50 rounded-lg border border-yellow-100 hover:bg-yellow-100 transition">
                            <h3 class="text-base font-medium text-yellow-700">All Bookings</h3>
                            <p class="mt-1 text-sm text-yellow-600">Manage customer bookings</p>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 