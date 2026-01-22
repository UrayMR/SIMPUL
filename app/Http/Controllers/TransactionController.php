<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Transaction::class);

        $search = $request->input('search');
        $transactions = Transaction::with(['user', 'course'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%");
                })
                    ->orWhereHas('course', function ($q) use ($search) {
                        $q->where('title', 'like', "%$search%");
                    });
            })
            ->orderByRaw("FIELD(status, 'pending', 'rejected', 'approved')")
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('pages.admin.transaction.index', [
            'transactions' => $transactions,
            'search' => $search,
            'currentPage' => $transactions->currentPage(),
            'lastPage' => $transactions->lastPage(),
            'perPage' => $transactions->perPage(),
            'total' => $transactions->total(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        $transaction->load('user', 'course');

        return view('pages.admin.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        if ($transaction->payment_proof_path && Storage::disk('public')->exists($transaction->payment_proof_path)) {
            Storage::disk('public')->delete($transaction->payment_proof_path);
        }

        $transaction->delete();

        return redirect()->route('admin.transactions.index')->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Approve a pending transaction.
     */
    public function approve(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if ($transaction->status !== Transaction::STATUS_PENDING) {
            return redirect()->back()->withErrors(['approve' => 'Aksi tidak valid.']);
        }
        $transaction->status = Transaction::STATUS_APPROVED;
        $transaction->save();

        $transaction->course->increment('enrollments_count');
        $transaction->course->enrollments()->create([
            'user_id' => $transaction->user_id,
            'course_id' => $transaction->course_id,
        ]);

        return redirect()->route('admin.transactions.show', $transaction)->with('success', 'Transaksi berhasil di-approve.');
    }

    /**
     * Reject a pending transaction.
     */
    public function reject(Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        if ($transaction->status !== Transaction::STATUS_PENDING) {
            return redirect()->back()->withErrors(['reject' => 'Aksi tidak valid.']);
        }

        $transaction->status = Transaction::STATUS_REJECTED;
        $transaction->save();

        return redirect()->route('admin.transactions.show', $transaction)->with('success', 'Transaksi berhasil direject.');
    }

    public function payment()
    {
        return view('pages.guest.transaction.payment');
    }

    public function history()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('course')
            ->orderByDesc('created_at')
            ->paginate(5);

        return view('pages.guest.transaction.history', compact('transactions'));

    }
}
