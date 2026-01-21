<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCourseController extends Controller
{
    public function index(Request $request)
{
    $search = trim((string) $request->query('search', ''));

    // Support category[] & categories[]
    $categoryIds = (array) $request->query(
        'category',
        $request->query('categories', [])
    );

    $ownership = $request->query('ownership'); // 'true' | 'false' | null
    $sortPrice = $request->query('sort_price'); // 'asc' | 'desc' | null

    $categories = Category::all();

    /* ======================
     | BASE QUERY
     ====================== */
    $query = Course::query()
        ->with(['category', 'teacher.user'])

        // 🔑 TAMBAHAN PENTING: FLAG is_owned
        ->withExists([
            'enrollments as is_owned' => function ($q) {
                $q->where('user_id', Auth::id());
            }
        ]);

    /* ======================
     | FILTER CATEGORY
     ====================== */
    if (!empty($categoryIds)) {
        $query->whereIn('category_id', $categoryIds);
    }

    /* ======================
     | FILTER SEARCH
     ====================== */
    if ($search !== '') {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /* ======================
     | FILTER OWNERSHIP
     ====================== */
    if (Auth::check()) {

        if ($ownership === 'true') {
            // Kursus yang SUDAH DIMILIKI user
            $query->whereHas('enrollments', function ($q) {
                $q->where('user_id', Auth::id());
            });

        } elseif ($ownership === 'false') {
            // Kursus yang BELUM DIMILIKI user
            $query->whereDoesntHave('enrollments', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

    } elseif ($ownership === 'true') {
        // Guest + pilih "Sudah Dimiliki" → kosongkan hasil
        $query->whereRaw('0 = 1');
    }

    /* ======================
     | SORT PRICE
     ====================== */
    if ($sortPrice === 'asc') {
        $query->orderBy('price', 'asc');
    } elseif ($sortPrice === 'desc') {
        $query->orderBy('price', 'desc');
    } else {
        // Default
        $query->orderBy('created_at', 'desc');
    }

    /* ======================
     | PAGINATION
     ====================== */
    $courses = $query
        ->paginate(12)
        ->withQueryString();

    return view('pages.guest.course.index', compact('categories', 'courses'));
}


    public function show(Course $course)
    {
        $course->load('category', 'teacher.user');

        $enrollment = Enrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id() ?? '')
            ->first();

        $enrolled = false;

        if (isset($enrollment)) {
            $enrolled = true;
        }
        // $course = Course::with('category', 'teacher')->findOrFail($id);
        return view('pages.guest.course.show', compact('course', 'enrolled'));
    }
}
