<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentProofFileRequest;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CoursePaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $courseId = $request->query('course_id');
        $course = $courseId ? Course::find($courseId) : null;

        if (! $course) {
            return redirect()->route('courses.index')
                ->with('error', 'Kursus tidak ditemukan. Silakan coba lagi.');
        }

        $transaction = Transaction::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('status', Transaction::STATUS_PENDING)
            ->first();

        if (! $transaction) {
            return redirect()->route('course.show', ['course' => $courseId])
                ->with('error', 'Transaksi pembayaran tidak ditemukan. Silakan coba lagi.');
        }

        // Jika token expired, generate token baru
        if ($transaction->payment_token_expires_at && $transaction->payment_token_expires_at->isPast()) {
            $token = Str::uuid()->toString();
            $expiresAt = now()->addMinutes(15);
            $transaction->update([
                'payment_token' => $token,
                'payment_token_expires_at' => $expiresAt,
            ]);
            // Refresh instance
            $transaction->refresh();
        }

        return view('pages.student.transaction.payment', [
            'course' => $course,
            'payment' => $transaction,
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
     * Store a newly created transaction and redirect to payment page.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $courseId = $request->input('course_id');
        $course = Course::findOrFail($courseId);

        // Cari transaksi pending
        $transaction = Transaction::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('status', Transaction::STATUS_PENDING)
            ->first();

        if (! $transaction) {
            $token = Str::uuid()->toString();
            $expiresAt = now()->addMinutes(15);
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'course_id' => $courseId,
                'amount' => $course->price,
                'status' => Transaction::STATUS_PENDING,
                'payment_token' => $token,
                'payment_token_expires_at' => $expiresAt,
            ]);
        }

        // Redirect ke halaman pembayaran
        return redirect()->route('student.payment.index', ['course_id' => $courseId]);
    }

    /**
     * Upload payment proof (bukti transfer).
     */
    public function apply(PaymentProofFileRequest $request)
    {
        $user = $request->user();
        $courseId = $request->input('course_id');
        $token = $request->input('payment_token');

        $transaction = Transaction::where('user_id', $user->id)
            ->where('course_id', $courseId)
            ->where('payment_token', $token)
            ->where('status', Transaction::STATUS_PENDING)
            ->first();

        if (! $transaction || ! $transaction->payment_token_expires_at || $transaction->payment_token_expires_at->isPast()) {
            return back()->with('error', 'Halaman pembayaran sudah expired. Silakan lakukan pembelian ulang.');
        }

        $file = $request->file('payment_proof_file');
        $filename = 'payment_'.$user->id.'_'.time().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('payments', $filename, 'public');

        $transaction->payment_proof_path = $path;
        $transaction->save();

        return redirect()->route('course.show', ['course_id' => $courseId])
            ->with('success', 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction) {}

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
    public function destroy(Transaction $transaction) {}

    /**
     * Approve a pending transaction.
     */
    public function approve(Transaction $transaction) {}

    /**
     * Reject a pending transaction.
     */
    public function reject(Transaction $transaction) {}
}
