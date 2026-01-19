<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;


class UserController extends Controller
{

    public function __construct() {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $search = $request->query('search');

        // User aktif/nonaktif
        $users = User::query()
            ->whereIn('status', [User::STATUS_ACTIVE, User::STATUS_INACTIVE])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->paginate(10);

        $currentPage = $users->currentPage();
        $lastPage = $users->lastPage();
        $perPage = $users->perPage();
        $total = $users->total();

        // Count user pending+rejected
        $pendingCount = User::query()
            ->whereIn('status', [User::STATUS_PENDING, User::STATUS_REJECTED])
            ->count();

        return view('pages.admin.user.index', compact(
            'users',
            'search',
            'currentPage',
            'lastPage',
            'perPage',
            'total',
            'pendingCount'
        ));
    }

    /**
     * Lazy: List user pending & rejected (for lazy load)
     */
    public function pendingList(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $search = $request->query('search');

        $users = User::query()
            ->whereIn('status', [User::STATUS_PENDING, User::STATUS_REJECTED])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("FIELD(status, 'pending', 'rejected')")
            ->orderByDesc('created_at')
            ->paginate(10);

        $links = (string) $users->links();

        return response()->json([
            'users' => $users,
            'links' => $links,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('pages.admin.user.create', compact('sekolahs', 'gerejas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        Gate::authorize('create', User::class);
        $user = $this->service->store($request->validated());
        return redirect()->route('admin.users.index')->with('success', ' Data Pengguna berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        Gate::authorize('view', $user);

        $user->load(['guru.sekolah', 'staffGereja']);

        $sekolahs = Sekolah::pluck('nama', 'id')
            ->toArray();
        $gerejas = Gereja::pluck('nama', 'id')
            ->toArray();

        return view('pages.admin.user.show', compact('user', 'sekolahs', 'gerejas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        Gate::authorize('update', $user);

        $user->load(['guru.sekolah', 'staffGereja']);

        $sekolahs = Sekolah::pluck('nama', 'id')
            ->toArray();
        $gerejas = Gereja::pluck('nama', 'id')
            ->toArray();

        return view('pages.admin.user.edit', compact('user', 'sekolahs', 'gerejas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        Gate::authorize('update', $user);
        $this->service->update($user, $request->validated());
        return redirect()->route('admin.users.index', $user)->with('success', ' Data Pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        $this->service->delete($user);
        return redirect()->route('admin.users.index')->with('success', ' Data Pengguna berhasil dihapus.');
    }
}
