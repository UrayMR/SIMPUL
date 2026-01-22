<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TeacherCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'video_url' => [
                'required',
                'url',
                function ($attribute, $value, $fail) {
                    if (! preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//', $value)) {
                        $fail('URL video harus berupa link YouTube.');
                    }
                },
            ],
            'thumbnail_file' => ['nullable', 'image', 'max:2048'],
        ];

        if ($this->isMethod('post')) {
            $rules['hero_file'] = ['required', 'image', 'max:4096'];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['hero_file'] = ['nullable', 'image', 'max:4096'];
        }

        return $rules;
    }
}
