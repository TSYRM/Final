<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = $user->isAdmin() 
            ? Booking::with(['user', 'service'])->get()
            : $user->bookings()->with('service')->get();
        
        return view('dashboard', [
            'bookings' => $bookings,
        ]);
    }
}
