<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherCourseController extends Controller
{

  public function index()
  {
    $teacher = Auth::user()->teacher;
    $courses = Course::with('category')
      ->where('teacher_id', $teacher->id)
      ->withSum(['transactions as transactions_sum_amount' => function ($q) {
        $q->where('status', Transaction::STATUS_APPROVED);
      }], 'amount')
      ->orderByDesc('created_at')
      ->get();

    $totalIncome = Transaction::whereHas('course', function ($q) use ($teacher) {
      $q->where('teacher_id', $teacher->id);
    })
      ->where('status', Transaction::STATUS_APPROVED)
      ->sum('amount');

    return view('pages.teacher.course.index', [
      'courses' => $courses,
      'totalIncome' => $totalIncome,
    ]);
  }

  public function create() {}
  public function store(Request $request) {}
  public function edit(Course $course) {}
  public function update(Request $request, Course $course) {}
  public function destroy(Course $course) {}
}
