<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = $user->isAdmin() 
            ? Booking::with(['user', 'service'])->get()
            : $user->bookings()->with('service')->get();
        
        // For admin, also get all users with booking counts
        $users = null;
        if ($user->isAdmin()) {
            $users = User::withCount('bookings')->get();
        }
        
        return view('dashboard', [
            'bookings' => $bookings,
            'users' => $users,
        ]);
    }
}
