<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        // sesuaikan otorisasi, misalnya true jika sudah login
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => 'required|string|max:255|unique:courses,title',
            'description'  => 'required|string',
            'rating'       => 'required|numeric|min:0|max:10',
            'category_id'  => 'required|exists:course_categories,id',
            'level'        => 'required|in:beginner,intermediate,advanced',
            'duration'     => 'required|integer|min:1',
            'thumbnail'    => 'nullable|string',
            'status'       => 'in:draft,published',
            'instructor_id'=> 'required|exists:users,id',
        ];
    }
}