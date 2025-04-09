@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="px-8 py-6 mt-4 text-left bg-white shadow-lg rounded-lg w-full max-w-md">
        <h3 class="text-2xl font-bold text-center text-gray-800">Login to your account</h3>
        
        <form method="POST" action="{{ route('login') }}" class="mt-4">
            @csrf
            
            <div class="mt-4">
                <label class="block text-gray-700" for="email">Email</label>
                <input type="email" id="email" name="email" 
                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    value="{{ old('email') }}" required autofocus>
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
            
            <div class="flex items-center mt-4">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
            </div>
            
            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="px-6 py-2 text-white bg-indigo-600 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Login
                </button>
                
                <a href="{{ route('register') }}" class="text-sm text-indigo-600 hover:underline">
                    Don't have an account? Register
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 