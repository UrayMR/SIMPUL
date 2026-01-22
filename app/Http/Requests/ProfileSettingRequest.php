<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileSettingRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:30'],
        ];

        if ($this->user() && $this->user()->role === User::ROLE_TEACHER) {
            $profilePhotoRule = $this->isMethod('post')
              ? ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048']
              : ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
            $rules = array_merge($rules, [
                'profile_photo' => $profilePhotoRule,
                'bio' => ['nullable', 'string', 'max:1000'],
                'expertise' => ['nullable', 'string', 'max:255'],
            ]);
        }

        return $rules;
    }
}
