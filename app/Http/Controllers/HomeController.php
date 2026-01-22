<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {

        $courses = Course::orderBy('enrollments_count', 'desc')->take(4)->get();

        return view('pages.guest.home', compact('courses'));
    }

    public function categories()
    {
        $categories = Category::withCount('courses')->orderBy('name')->get();

        return view('pages.guest.category', compact('categories'));
    }
}
