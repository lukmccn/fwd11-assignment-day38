<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    use ApiResponses;
    
    public function index()
    {
        $courses = Course::with(['category', 'instructor'])->latest()->get();
        return $this->successResponse(
            CourseResource::collection($courses),
            'Data kursus berhasil diambil'
        );
    }

    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->validated());
        // Muat relasi untuk ditampilkan di Resource
        $course->load(['category', 'instructor']);

        return $this->successResponse(
            new CourseResource($course),
            'Kursus berhasil dibuat',
            201
        );
    }

    public function show(string $id)
    {
        $course = Course::with(['category', 'instructor', 'enrollments'])->find($id);
        if (!$course) {
            return $this->notFoundResponse('Kursus tidak ditemukan');
        }

        return $this->successResponse(
            new CourseResource($course),
            'Detail kursus berhasil diambil'
        );
    }

    public function update(Request $request, string $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return $this->notFoundResponse('Kursus tidak ditemukan');
        }

        $validated = $request->validate([
            'title'        => 'sometimes|string|max:255',
            'description'  => 'sometimes|string',
            'rating'       => 'sometimes|numeric|min:0|max:10',
            'category_id'  => 'sometimes|exists:course_categories,id',
            'level'        => 'sometimes|in:beginner,intermediate,advanced',
            'duration'     => 'sometimes|integer|min:1',
            'thumbnail'    => 'nullable|string',
            'status'       => 'in:draft,published',
            'instructor_id'=> 'sometimes|exists:users,id',
        ]);

        $course->update($validated);
        $course->load(['category', 'instructor']);

        return $this->successResponse(
            new CourseResource($course),
            'Kursus berhasil diperbarui'
        );
    }

    public function destroy(string $id)
    {
        $course = Course::find($id);
        if (!$course) {
            return $this->notFoundResponse('Kursus tidak ditemukan');
        }

        $course->delete();
        return $this->successResponse(null, 'Kursus berhasil dihapus');
    }
}