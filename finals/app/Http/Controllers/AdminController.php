<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Admin check will happen on each method
    }

    /**
     * Check if user is admin or abort with 403
     */
    private function checkAdmin()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show user management view.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function users()
    {
        $this->checkAdmin();
        $users = User::withCount('bookings')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Show specific user details.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function showUser(User $user)
    {
        $this->checkAdmin();
        $bookings = $user->bookings()->with('service')->latest()->get();
        return view('admin.user-detail', compact('user', 'bookings'));
    }

    /**
     * Toggle user role between admin and regular user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleUserRole(User $user)
    {
        $this->checkAdmin();
        // Prevent changing your own role
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot change your own role.');
        }
        
        $user->role = $user->isAdmin() ? 'user' : 'admin';
        $user->save();
        
        return redirect()->route('admin.users')
            ->with('status', "User {$user->name} is now a " . ucfirst($user->role));
    }
    
    /**
     * Delete a user and all their bookings.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser(User $user)
    {
        $this->checkAdmin();
        
        try {
            // Prevent deleting yourself
            if (Auth::id() === $user->id) {
                return back()->with('error', 'You cannot delete your own account.');
            }
            
            // Get user name for confirmation message
            $userName = $user->name;
            $userId = $user->id;
            
            // Log the deletion attempt
            Log::info('Attempting to delete user', [
                'user_id' => $userId,
                'user_name' => $userName,
                'deleted_by' => Auth::id()
            ]);
            
            // Delete all user's bookings
            $bookingsCount = $user->bookings()->count();
            $user->bookings()->delete();
            Log::info('Deleted user bookings', ['count' => $bookingsCount]);
            
            // Delete the user
            $user->delete();
            Log::info('User deleted successfully', ['user_id' => $userId]);
            
            return redirect()->route('admin.users')
                ->with('status', "User {$userName} has been deleted successfully along with all their bookings.");
        } catch (\Exception $e) {
            Log::error('Error deleting user', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'An error occurred while deleting the user: ' . $e->getMessage());
        }
    }
} 