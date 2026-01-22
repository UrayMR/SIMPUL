<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user = $this->route('user');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'phone_number' => ['required', 'string', 'max:15'],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_TEACHER, User::ROLE_STUDENT])],
            'status' => ['required', Rule::in([User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_PENDING, User::STATUS_REJECTED])],
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = ['required', 'string', 'confirmed'];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = ['nullable', 'string', 'confirmed'];
        }

        // RULES TEACHER
        if ($this->input('role') === User::ROLE_TEACHER) {
            $profilePictureRules = ['file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'];
            $user = $this->route('user');
            $hasOldPhoto = $user && $user->teacher && !empty($user->teacher->profile_picture_path);
            if ($this->isMethod('post') || !$hasOldPhoto) {
                array_unshift($profilePictureRules, 'required');
            } else {
                array_unshift($profilePictureRules, 'nullable');
            }
            $rules = array_merge($rules, [
                'profile_picture_file' => $profilePictureRules,
                'bio' => ['nullable', 'string', 'max:1000'],
                'expertise' => ['nullable', 'string', 'max:255'],
            ]);
        }

        return $rules;
    }
}
