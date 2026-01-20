<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseUserController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        // Support both 'category[]' and legacy 'categories' query keys
        $categoryIds = (array) $request->query('category', $request->query('categories', []));

        $categories = Category::all();

        $query = Course::query()->with('category', 'teacher');

        if (!empty($categoryIds)) {
            $query->whereIn('category_id', $categoryIds);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $courses = $query->orderBy('created_at')->paginate(12)->withQueryString();

        return view('pages.guest.course.index', compact('categories', 'courses'));
    }

    public function show(Course $course)
    {
        $course->load('category', 'teacher.user');
        // $course = Course::with('category', 'teacher')->findOrFail($id);
        return view('pages.guest.course.show', compact('course'));
    }
}
