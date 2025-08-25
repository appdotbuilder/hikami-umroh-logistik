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

class DashboardController extends Controller
{
    /**
     * Display the dashboard based on user role.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }

        $data = [
            'user' => $user->load('jamaah'),
        ];

        // Role-specific data
        if ($user->isSuperadmin()) {
            $data['admin_stats'] = [
                'total_users' => User::count(),
                'superadmin_count' => User::byRole('superadmin')->count(),
                'staffadmin_count' => User::byRole('staffadmin')->count(),
                'jamaah_count' => User::byRole('jamaah')->count(),
                'total_revenue' => Payment::where('status', 'paid')->sum('amount'),
                'total_expenses' => \App\Models\Expense::sum('amount'),
            ];
        } elseif ($user->isStaffadmin()) {
            $data['staff_stats'] = [
                'jamaah_count' => Jamaah::count(),
                'pending_documents' => Document::where('status', 'pending')->count(),
                'pending_payments' => Payment::where('status', 'pending')->count(),
                'overdue_payments' => Payment::overdue()->count(),
                'equipment_low_stock' => Equipment::whereRaw('stock_quantity - distributed_quantity <= 10')->count(),
            ];
        } elseif ($user->isJamaah()) {
            $jamaah = $user->jamaah;
            if ($jamaah) {
                $data['jamaah_data'] = [
                    'profile' => $jamaah,
                    'assignment' => $jamaah->assignment?->load(['travelPackage', 'accommodation', 'departureFlight', 'returnFlight']),
                    'documents' => $jamaah->documents()->get(),
                    'payments' => $jamaah->payments()->with('travelPackage')->get(),
                    'equipment' => $jamaah->equipmentDistributions()->with('equipment')->get(),
                ];
            }
        }

        return Inertia::render('dashboard', $data);
    }
}