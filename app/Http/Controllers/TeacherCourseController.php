<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Http\Requests\TeacherCourseRequest;
use App\Models\Course;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCourseRequest;
use App\Models\Category;
use App\Utils\ImageCompressor;
use App\Utils\YoutubeUrlParser;
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

  public function create()
  {
    $categories = Category::query()->orderBy('name')->pluck('name', 'id')->toArray();

    return view('pages.teacher.course.create', [
      'categories' => $categories,
    ]);
  }

  public function store(TeacherCourseRequest $request)
  {
    $teacher = Auth::user()->teacher;

    $data = $request->validated();

    if ($request->hasFile('thumbnail_file')) {
      $data['thumbnail_path'] = $request->file('thumbnail_file')->store('course-thumbnails', 'public');
    } elseif ($request->hasFile('hero_file')) {
      // Generate thumbnail from hero_file
      $data['thumbnail_path'] = ImageCompressor::compressThumbnail($request->file('hero_file'));
    } else {
      unset($data['thumbnail_path']);
    }

    if ($request->hasFile('hero_file')) {
      $data['hero_path'] = $request->file('hero_file')->store('course-heroes', 'public');
    } else {
      unset($data['hero_path']);
    }

    $data['teacher_id'] = $teacher->id;
    $data['status'] = Course::STATUS_PENDING;
    $data['video_url'] = YoutubeUrlParser::extractId($data['video_url'] ?? '');

    Course::create($data);

    return redirect()->route('teacher.courses.index')->with('success', 'Kursus berhasil ditambahkan dan menunggu persetujuan admin.');
  }

  public function edit(Course $course) {}
  public function update(Request $request, Course $course) {}
  public function destroy(Course $course) {}
}
