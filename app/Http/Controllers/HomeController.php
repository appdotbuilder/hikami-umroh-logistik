<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jamaah;
use App\Models\TravelPackage;
use App\Models\Payment;
use App\Models\Document;
use App\Models\Equipment;
use Inertia\Inertia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with system overview.
     */
    public function index()
    {
        // Get basic statistics for the dashboard
        $stats = [
            'total_jamaah' => Jamaah::count(),
            'total_packages' => TravelPackage::count(),
            'active_packages' => TravelPackage::whereIn('status', ['open', 'draft'])->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'pending_documents' => Document::where('status', 'pending')->count(),
            'available_equipment' => Equipment::where('status', 'available')->sum('stock_quantity'),
        ];

        // Get recent packages
        $recent_packages = TravelPackage::latest()
            ->take(3)
            ->get(['id', 'name', 'departure_date', 'price', 'capacity', 'registered_count', 'status']);

        // Get upcoming departures
        $upcoming_departures = TravelPackage::where('departure_date', '>', now())
            ->where('status', 'open')
            ->orderBy('departure_date')
            ->take(5)
            ->get(['id', 'name', 'departure_date', 'registered_count', 'capacity']);

        return Inertia::render('welcome', [
            'stats' => $stats,
            'recent_packages' => $recent_packages,
            'upcoming_departures' => $upcoming_departures,
        ]);
    }


}