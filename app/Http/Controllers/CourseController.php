<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Teacher;
use App\Http\Requests\CourseRequest;
use App\Models\User;
use App\Utils\ImageCompressor;
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
        $this->authorize('create', Course::class);
        $categories = Category::query()->orderBy('name')->pluck('name', 'id')->toArray();
        $teachers = Teacher::with('user')
            ->whereHas('user', function ($q) {
                $q->where('users.status', User::STATUS_ACTIVE);
            })
            ->get()
            ->mapWithKeys(fn($t) => [$t->id => $t->user->name])
            ->toArray();
        return view('pages.admin.course.create', compact('categories', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $this->authorize('create', Course::class);

        $validated = $request->validated();

        if ($request->hasFile('thumbnail_file')) {
            $validated['thumbnail_path'] = $request->file('thumbnail_file')->store('course-thumbnails', 'public');
        } elseif ($request->hasFile('hero_file')) {
            // Generate thumbnail from hero_file
            $validated['thumbnail_path'] = ImageCompressor::compressThumbnail($request->file('hero_file'));
        } else {
            unset($validated['thumbnail_path']);
        }

        if ($request->hasFile('hero_file')) {
            $validated['hero_path'] = $request->file('hero_file')->store('course-heroes', 'public');
        } else {
            unset($validated['hero_path']);
        }

        $validated['status'] = Course::STATUS_PENDING;
        $validated['enrollments_count'] = 0;

        Course::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil ditambahkan dan menunggu persetujuan.');
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
    public function update(CourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validated();

        if ($request->hasFile('thumbnail_path')) {
            $validated['thumbnail_path'] = $request->file('thumbnail_path')->store('course-thumbnails', 'public');
        } else {
            unset($validated['thumbnail_path']);
        }

        if ($request->hasFile('hero_path')) {
            $validated['hero_path'] = $request->file('hero_path')->store('course-heroes', 'public');
        } else {
            unset($validated['hero_path']);
        }

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Kursus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
    }
}
