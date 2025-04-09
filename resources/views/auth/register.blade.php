@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg rounded-lg w-full max-w-md">
        <h3 class="text-2xl font-bold text-center text-gray-800">Create an account</h3>
        
        <form method="POST" action="{{ route('register') }}" class="mt-4">
            @csrf
            
            <div class="mt-4">
                <label class="block text-gray-700" for="name">Name</label>
                <input type="text" id="name" name="name" 
                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    value="{{ old('name') }}" required autofocus>
                @error('name')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <label class="block text-gray-700" for="email">Email</label>
                <input type="email" id="email" name="email" 
                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <label class="block text-gray-700" for="password">Password</label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
                @error('password')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mt-4">
                <label class="block text-gray-700" for="password_confirmation">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    required>
            </div>
            
            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="px-6 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Register
                </button>
                
                <a href="{{ route('login') }}" class="text-sm text-indigo-600 hover:underline">
                    Already have an account? Login
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 