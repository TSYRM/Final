<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = auth()->user()->isAdmin() 
            ? Booking::with(['user', 'service'])->get()
            : auth()->user()->bookings()->with('service')->get();
        
        return response()->json($bookings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'booking_date' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $booking = auth()->user()->bookings()->create($validated);
        return response()->json($booking, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return response()->json($booking->load(['user', 'service']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $this->authorize('update', $booking);

        $validated = $request->validate([
            'status' => 'sometimes|required|in:pending,confirmed,cancelled,completed',
            'notes' => 'sometimes|nullable|string',
        ]);

        $booking->update($validated);
        return response()->json($booking);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();
        return response()->json(null, 204);
    }
}
