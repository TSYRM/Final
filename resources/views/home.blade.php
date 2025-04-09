@extends('layouts.app')

@section('content')
<div class="relative flex items-center justify-center min-h-screen bg-gray-100">
    <div class="relative px-6 pt-10 pb-8 bg-white shadow-xl ring-1 ring-gray-900/5 sm:max-w-lg sm:mx-auto sm:rounded-lg sm:px-10">
        <div class="max-w-md mx-auto">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-indigo-600">Welcome to {{ config('app.name', 'Laravel') }}</h1>
                <p class="mt-3 text-lg text-gray-500">Your trusted service booking platform</p>
            </div>
            
            <div class="mt-8 text-center">
                <p class="text-gray-600 mb-6">Discover and book professional services with ease</p>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                        Dashboard
                    </a>
                @else
                    <div class="space-x-4">
                        <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Login
                        </a>
                        
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
            
            <div class="mt-10">
                <h2 class="text-xl font-semibold text-gray-800">Our Services</h2>
                <p class="mt-2 text-gray-600">We offer a wide range of professional services to meet your needs</p>
                
                <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-medium text-gray-900">Professional Cleaning</h3>
                        <p class="text-sm text-gray-500">Expert cleaning services for homes and offices</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-medium text-gray-900">Home Repairs</h3>
                        <p class="text-sm text-gray-500">Reliable repair services for all your home needs</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-medium text-gray-900">Tech Support</h3>
                        <p class="text-sm text-gray-500">Expert tech support for all your devices</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                        <h3 class="font-medium text-gray-900">Consultations</h3>
                        <p class="text-sm text-gray-500">Professional advice from industry experts</p>
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('services.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">View all services →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 