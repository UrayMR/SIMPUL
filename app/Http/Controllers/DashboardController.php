<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{


public function index()
{
    $stats = [
        // ======================
        // PENGGUNA
        // ======================
        'teacher_active' => User::where('role', 'teacher')
            ->where('status', 'active')
            ->count(),

        'student_active' => User::where('role', 'student')
            ->where('status', 'active')
            ->count(),

        'user_pending' => User::where('status', 'pending')
            ->count(),

        // ======================
        // KURSUS
        // ======================
        'total_course' => Course::count(),

        'course_active' => Course::where('status', 'aktif')->count(),

        'course_pending' => Course::where('status', 'pending')->count(),

        // ======================
        // TRANSAKSI
        // ======================
        'total_transaction' => Transaction::count(),

        'transaction_pending' => Transaction::where('status', 'pending')->count(),

        'today_income' => Transaction::where('status', 'approved')
            ->whereDate('created_at', Carbon::today())
            ->sum('amount'),

        'monthly_income' => Transaction::where('status', 'approved')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount'),
    ];
    return view('pages.admin.dashboard', compact('stats'));
}

}
