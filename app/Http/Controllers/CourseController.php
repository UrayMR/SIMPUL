<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Course::class);

        $search = $request->input('search');

        $query = Course::with(['category', 'teacher.user'])->where('status', Course::STATUS_APPROVED);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($cat) use ($search) {
                        $cat->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('teacher.user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $courses = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        // Count courses pending+rejected
        $pendingCount = Course::query()
            ->whereIn('status', [Course::STATUS_PENDING, Course::STATUS_REJECTED])
            ->count();

        return view('pages.admin.course.index', [
            'courses' => $courses,
            'search' => $search,
            'currentPage' => $courses->currentPage(),
            'lastPage' => $courses->lastPage(),
            'perPage' => $courses->perPage(),
            'total' => $courses->total(),
            'pendingCount' => $pendingCount,
        ]);
    }

    /**
     * Lazy: List user pending & rejected (for lazy load)
     */
    public function pendingList()
    {
        $this->authorize('viewAny', Course::class);

        $courses = Course::query()
            ->with(['category', 'teacher.user'])
            ->whereIn('status', [Course::STATUS_PENDING, Course::STATUS_REJECTED])
            ->orderByRaw("FIELD(status, 'pending', 'rejected')")
            ->orderByDesc('created_at')
            ->paginate(10);

        $links = (string) $courses->links();

        return response()->json([
            'courses' => $courses,
            'links' => $links,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
