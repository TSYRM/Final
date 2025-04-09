<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Ensure that only admins can access these routes
     */
    public function __construct()
    {
        // The middleware is applied in the routes file already
        // Route::middleware(['admin'])->group(...
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::withCount('bookings')->get();
        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
        ]);

        Service::create($request->all());

        return redirect()->route('admin.services.index')
            ->with('status', 'Service created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:15',
        ]);

        $service->update($request->all());

        return redirect()->route('admin.services.index')
            ->with('status', 'Service updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        // Check if the service has any bookings
        if ($service->bookings()->exists()) {
            return redirect()->route('services.index')
                ->with('error', 'Cannot delete this service because it has existing bookings');
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('status', 'Service deleted successfully!');
    }
}
