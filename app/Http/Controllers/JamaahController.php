<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJamaahRequest;
use App\Http\Requests\UpdateJamaahRequest;
use App\Models\Jamaah;
use App\Models\User;
use App\Models\TravelPackage;
use Inertia\Inertia;
use Illuminate\Http\Request;

class JamaahController extends Controller
{
    /**
     * Display a listing of jamaah.
     */
    public function index(Request $request)
    {
        $query = Jamaah::query()->with(['user', 'assignment.travelPackage']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by name or NIK
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('email', 'like', "%{$search}%");
                  });
            });
        }

        $jamaah = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('jamaah/index', [
            'jamaah' => $jamaah,
            'filters' => $request->only(['status', 'search']),
            'statuses' => [
                'registered' => 'Terdaftar',
                'documents_pending' => 'Dokumen Pending',
                'documents_complete' => 'Dokumen Lengkap',
                'ready_to_depart' => 'Siap Berangkat',
                'departed' => 'Berangkat',
                'returned' => 'Pulang',
            ],
        ]);
    }

    /**
     * Show the form for creating a new jamaah.
     */
    public function create()
    {
        $users = User::byRole('jamaah')
            ->whereDoesntHave('jamaah')
            ->get(['id', 'name', 'email']);

        return Inertia::render('jamaah/create', [
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created jamaah in storage.
     */
    public function store(StoreJamaahRequest $request)
    {
        $jamaah = Jamaah::create($request->validated());

        return redirect()->route('jamaah.show', $jamaah)
            ->with('success', 'Data jamaah berhasil dibuat.');
    }

    /**
     * Display the specified jamaah.
     */
    public function show(Jamaah $jamaah)
    {
        $jamaah->load([
            'user',
            'assignment.travelPackage',
            'assignment.accommodation',
            'assignment.departureFlight',
            'assignment.returnFlight',
            'documents.reviewer',
            'payments.travelPackage',
            'equipmentDistributions.equipment',
        ]);

        return Inertia::render('jamaah/show', [
            'jamaah' => $jamaah,
        ]);
    }

    /**
     * Show the form for editing the specified jamaah.
     */
    public function edit(Jamaah $jamaah)
    {
        $jamaah->load('user');

        return Inertia::render('jamaah/edit', [
            'jamaah' => $jamaah,
        ]);
    }

    /**
     * Update the specified jamaah in storage.
     */
    public function update(UpdateJamaahRequest $request, Jamaah $jamaah)
    {
        $jamaah->update($request->validated());

        return redirect()->route('jamaah.show', $jamaah)
            ->with('success', 'Data jamaah berhasil diperbarui.');
    }

    /**
     * Remove the specified jamaah from storage.
     */
    public function destroy(Jamaah $jamaah)
    {
        $jamaah->delete();

        return redirect()->route('jamaah.index')
            ->with('success', 'Data jamaah berhasil dihapus.');
    }


}