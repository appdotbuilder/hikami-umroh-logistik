<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query()->with('jamaah');

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $active = $request->status === 'active';
            $query->where('is_active', $active);
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return Inertia::render('users/index', [
            'users' => $users,
            'filters' => $request->only(['role', 'search', 'status']),
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return Inertia::render('users/create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return redirect()->route('users.show', $user)
            ->with('success', 'User berhasil dibuat.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['jamaah.assignment.travelPackage', 'jamaah.documents', 'jamaah.payments']);

        return Inertia::render('users/show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return Inertia::render('users/edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());

        return redirect()->route('users.show', $user)
            ->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting the last superadmin
        if ($user->isSuperadmin() && User::byRole('superadmin')->count() <= 1) {
            return back()->with('error', 'Tidak dapat menghapus superadmin terakhir.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }


}