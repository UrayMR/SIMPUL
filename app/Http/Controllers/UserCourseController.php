<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCourseController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        // Support category[] & categories[]
        $categoryIds = (array) $request->query('category', $request->query('categories', []));

        $ownership = $request->query('ownership'); // 'true' | 'false' | null

        $sortPrice = $request->query('sort_price', null);

        $categories = Category::all();

        $query = Course::query()
            ->with(['category', 'teacher']);

        $query->where('status', Course::STATUS_APPROVED);
        /* ======================
     | FILTER CATEGORY
     ====================== */
        if (! empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        /* ======================
     | FILTER SEARCH
     ====================== */
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        /* ======================
     | FILTER OWNERSHIP
     ====================== */

        if (Auth::check()) {

            if ($ownership === 'true') {
                // SUDAH DIMILIKI (teacher OR enrolled)
                $query->where(function ($q) {
                    $q->whereHas('enrollments', function ($q2) {
                        $q2->where('user_id', Auth::id());
                    })
                        ->orWhereHas('teacher', function ($q2) {
                            $q2->where('user_id', Auth::id());
                        });
                });
            } elseif ($ownership === 'false') {
                // BELUM DIMILIKI
                $query->whereDoesntHave('enrollments', function ($q) {
                    $q->where('user_id', Auth::id());
                })
                    ->whereDoesntHave('teacher', function ($q) {
                        $q->where('user_id', Auth::id());
                    });
            }
        } elseif ($ownership === 'true') {
            // Guest + pilih "Sudah Dimiliki"
            $query->whereRaw('0 = 1');
        }

        /* ======================
     | FILTER OWNERSHIP
     ====================== */
        if ($sortPrice === 'asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sortPrice === 'desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->orderBy('created_at', 'desc');
        }

        /* ======================
     | PAGINATION
     ====================== */
        $courses = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('pages.guest.course.index', compact('categories', 'courses'));
    }

    public function show(Course $course)
    {
        $course->load('category', 'teacher.user');

        $isOwned = false;

        if (Auth::check()) {

            // 1️⃣ cek apakah user adalah teacher pembuat kursus
            if ($course->teacher && $course->teacher->user_id === Auth::id()) {
                $isOwned = true;
            }

            // 2️⃣ cek apakah user sudah enroll
            elseif (
                $course->enrollments()
                    ->where('user_id', Auth::id())
                    ->exists()
            ) {
                $isOwned = true;
            }
        }

        return view('pages.guest.course.show', [
            'course' => $course,
            'enrolled' => $isOwned,
        ]);
    }
}
