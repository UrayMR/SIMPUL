<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherCourseRequest;
use App\Models\Course;
use App\Models\Transaction;
use App\Models\Category;
use App\Utils\ImageCompressor;
use App\Utils\YoutubeUrlParser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherCourseController extends Controller
{
  public function index()
  {
    $this->authorize('viewAny', Course::class);
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

  public function show(Course $course)
  {
    $this->authorize('view', $course);

    $course->load(['category', 'teacher.user']);

    if (!isset($course->enrollments_count)) {
      $course->enrollments_count = $course->enrollments()->count();
    }
    // Compute total approved transaction amount for this course
    $transactionsSumAmount = $course->transactions()
      ->where('status', Transaction::STATUS_APPROVED)
      ->sum('amount');
  
    return view('pages.teacher.course.show', [
      'course' => $course,
      'transactionsSumAmount' => $transactionsSumAmount,
    ]);
  }

  public function create()
  {
    $this->authorize('create', Course::class);

    $categories = Category::query()->orderBy('name')->pluck('name', 'id')->toArray();

    return view('pages.teacher.course.create', [
      'categories' => $categories,
    ]);
  }

  public function store(TeacherCourseRequest $request)
  {
    $this->authorize('create', Course::class);

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

  public function edit(Course $course)
  {
    $this->authorize('update', $course);

    $categories = Category::query()->orderBy('name')->pluck('name', 'id')->toArray();

    return view('pages.teacher.course.edit', [
      'course' => $course,
      'categories' => $categories,
    ]);
  }

  public function update(TeacherCourseRequest $request, Course $course)
  {
    $this->authorize('update', $course);

    $data = $request->validated();

    // Handle thumbnail
    if ($request->hasFile('thumbnail_file')) {
      $data['thumbnail_path'] = $request->file('thumbnail_file')->store('course-thumbnails', 'public');
    } elseif ($request->hasFile('hero_file')) {
      $data['thumbnail_path'] = ImageCompressor::compressThumbnail($request->file('hero_file'));
    } elseif ($course->thumbnail_path && !$request->input('enable-thumbnail')) {
      // Hanya set null jika checkbox tidak dicentang dan thumbnail_path memang custom
      if (!str_contains($course->thumbnail_path, 'thumb_')) {
        $data['thumbnail_path'] = null;
      }
    }

    // Handle hero
    if ($request->hasFile('hero_file')) {
      $data['hero_path'] = $request->file('hero_file')->store('course-heroes', 'public');
    } else {
      unset($data['hero_path']);
    }

    $data['video_url'] = YoutubeUrlParser::extractId($data['video_url'] ?? '');

    $course->update($data);

    return redirect()->route('teacher.courses.index')->with('success', 'Kursus berhasil diperbarui.');
  }

  public function destroy(Course $course)
  {
    $this->authorize('delete', $course);

    if ($course->thumbnail_path && Storage::disk('public')->exists($course->thumbnail_path)) {
      Storage::disk('public')->delete($course->thumbnail_path);
    }

    // Hapus file hero jika ada dan file benar-benar ada di storage
    if ($course->hero_path && Storage::disk('public')->exists($course->hero_path)) {
      Storage::disk('public')->delete($course->hero_path);
    }

    $course->delete();

    return redirect()->route('teacher.courses.index')->with('success', 'Kursus berhasil dihapus.');
  }
}
