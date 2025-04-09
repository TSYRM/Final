<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::where('is_available', true)->get();
        
        return Inertia::render('Home', [
            'services' => $services,
        ]);
    }
}
