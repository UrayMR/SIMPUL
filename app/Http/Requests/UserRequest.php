<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            $rules = array_merge($rules, [
                'nomor_telepon' => ['required', 'string', 'max:15'],
                'profile_photo_file' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);
        }

        return $rules;
    }
}
