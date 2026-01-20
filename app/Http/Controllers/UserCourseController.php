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
        // Support both 'category[]' and legacy 'categories' query keys
        $categoryIds = (array) $request->query('category', $request->query('categories', []));

        $ownership = $request->query('ownership', null);

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
        // if($ownership === 'true') {
        //     // Courses owned by the authenticated user
        //     $query->whereHas('enrollments', function ($q) {
        //         $q->where('user_id', Auth::id());
        //     });
        // } elseif ($ownership === 'false') {
        //     // Courses not owned by the authenticated user
        //     $query->whereDoesntHave('enrollments', function ($q) {
        //         $q->where('user_id', Auth::id());
        //     });
        // }
        $courses = $query->orderBy('created_at')->paginate(12)->withQueryString();

        return view('pages.guest.course.index', compact('categories', 'courses'));
    }

    public function show(Course $course)
    {
        $course->load('category', 'teacher.user');

        $enrollment = Enrollment::where('course_id', $course->id)
            ->where('user_id', Auth::id() ?? '')
            ->first();

        $enrolled = false;
        
        if(isset($enrollment)) {
             $enrolled = true;
        } 
        // $course = Course::with('category', 'teacher')->findOrFail($id);
        return view('pages.guest.course.show', compact('course', 'enrolled'));
    }
}
