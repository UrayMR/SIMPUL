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

            'teacher_active' => User::where('role', User::ROLE_TEACHER)
                ->where('status', User::STATUS_ACTIVE)
                ->count(),

            'student_active' => User::where('role', User::ROLE_STUDENT)
                ->where('status', User::STATUS_ACTIVE)
                ->count(),

            'user_pending' => User::where('status', User::STATUS_PENDING)
                ->count(),

            // ======================
            // KURSUS
            // ======================

            'total_course' => Course::count(),

            'course_active' => Course::where('status', Course::STATUS_APPROVED)->count(),

            'course_pending' => Course::where('status', Course::STATUS_PENDING)->count(),

            // ======================
            // TRANSAKSI
            // ======================
            'total_transaction' => Transaction::count(),

            'transaction_pending' => Transaction::where('status', Transaction::STATUS_PENDING)->count(),

            'today_income' => Transaction::where('status', Transaction::STATUS_APPROVED)
                ->whereDate('created_at', Carbon::today())
                ->sum('amount'),

            'monthly_income' => Transaction::where('status', Transaction::STATUS_APPROVED)
                ->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('amount'),
        ];
        return view('pages.admin.dashboard', compact('stats'));
    }
}
