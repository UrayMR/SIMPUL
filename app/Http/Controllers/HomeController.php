<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $courses = Course::orderBy('enrollments_count', 'desc')->take(4)->get();
        return view('pages.guest.home', compact('courses'));
    }
}
