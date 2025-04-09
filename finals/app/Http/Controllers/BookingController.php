<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BookingController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('service')->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('bookings.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking = Auth::user()->bookings()->create([
            'service_id' => $request->service_id,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')
            ->with('status', 'Booking created successfully. It is now pending approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        // Simple authorization check
        if (Auth::user()->isAdmin() || Auth::user()->id === $booking->user_id) {
            return view('bookings.show', compact('booking'));
        }
        
        abort(403, 'Unauthorized action.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        // Simple authorization check
        if (Auth::user()->isAdmin() || Auth::user()->id === $booking->user_id) {
            $services = Service::all();
            return view('bookings.edit', compact('booking', 'services'));
        }
        
        abort(403, 'Unauthorized action.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        // Different validation rules based on who is updating
        if (Auth::user()->isAdmin() && $request->has('status')) {
            // Admin might just be changing the status
            $request->validate([
                'status' => 'required|in:pending,confirmed,cancelled',
            ]);
            
            $booking->update([
                'status' => $request->status,
            ]);
            
            return redirect()->route('dashboard')
                ->with('status', 'Booking status updated successfully.');
        } else {
            // Simple authorization check for regular user or admin editing booking details
            if (!Auth::user()->isAdmin() && Auth::user()->id !== $booking->user_id) {
                abort(403, 'Unauthorized action.');
            }
            
            $request->validate([
                'service_id' => 'required|exists:services,id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'notes' => 'nullable|string|max:500',
            ]);
            
            // If admin is editing a booking for a user, don't reset status to pending
            $newStatus = Auth::user()->isAdmin() ? $booking->status : 'pending';
            
            $booking->update([
                'service_id' => $request->service_id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'notes' => $request->notes,
                'status' => $newStatus, // Reset to pending when regular user modifies, keep status when admin modifies
            ]);
            
            $message = Auth::user()->isAdmin() 
                ? 'Booking updated successfully.'
                : 'Booking updated successfully. It is now pending approval again.';
            
            return redirect()->route('dashboard')
                ->with('status', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Check if admin
        if (Auth::user()->isAdmin()) {
            // Admin can permanently delete bookings
            $booking->delete();
            
            return redirect()->route('dashboard')
                ->with('status', 'Booking permanently deleted successfully.');
        } else {
            // Regular user can only cancel their own bookings
            if (Auth::user()->id !== $booking->user_id) {
                abort(403, 'Unauthorized action.');
            }
            
            // Instead of actually deleting, we just set status to cancelled
            $booking->update(['status' => 'cancelled']);
            
            return redirect()->route('dashboard')
                ->with('status', 'Booking cancelled successfully.');
        }
    }
}
