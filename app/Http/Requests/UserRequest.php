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

        // RULE DASAR (BERLAKU UNTUK CREATE & UPDATE)
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user?->id)],
            'nomor_telepon' => ['required', 'string', 'max:15'],
            'profile_photo_path' => ['nullable', 'file', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'role' => ['required', Rule::in([User::ROLE_ADMIN, User::ROLE_GURU, User::ROLE_STAFF_GEREJA])],
            'status' => ['required', Rule::in([User::STATUS_AKTIF, User::STATUS_NONAKTIF])],
        ];

        // PASSWORD
        if ($this->isMethod('post')) {
            // CREATE
            $rules['password'] = ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            // UPDATE
            $rules['password'] = ['nullable', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'confirmed'];
        }



        // RULES GURU
        if ($this->input('role') === User::ROLE_GURU) {
            $rules = array_merge($rules, [
                'nik' => [
                    'required',
                    'string',
                    'max:50',
                    $this->isMethod('post')
                        ? Rule::unique('gurus', 'nik')
                        : Rule::unique('gurus', 'nik')->ignore(optional($user->guru)->id)
                ],
                'tempat_lahir' => ['required', 'string', 'max:100'],
                'tanggal_lahir' => ['required', 'date'],
                'sekolah_id' => ['required', 'array'],
                'sekolah_id.*' => ['exists:sekolahs,id'],
            ]);
        }

        // RULES STAFF GEREJA
        if ($this->input('role') === User::ROLE_STAFF_GEREJA) {
            $rules = array_merge($rules, [
                'gereja_id' => ['required', 'exists:gerejas,id'],
            ]);
        }

        return $rules;
    }


    public function guruRules(): array
    {
        $user = $this->route('user');
        $guruRules = [
            'nik' => [
                'required',
                'string',
                'max:50',
                $this->isMethod('post')
                    ? Rule::unique('gurus', 'nik')
                    : Rule::unique('gurus', 'nik')
                    ->ignore(optional($user->guru)->id)
                    ->where(fn($q) => $q->where('user_id', $user->id))
            ],
            'tempat_lahir' => ['required', 'string', 'max:100'],
            'tanggal_lahir' => ['required', 'date'],
            'sekolah_id' => ['required', 'array'],
            'sekolah_id.*' => ['exists:sekolahs,id']
        ];

        return $guruRules;
    }

    public function staffGerejaRules(): array
    {
        $staffGerejaRules = [
            'gereja_id' => ['required', 'exists:gerejas,id'],
        ];

        return $staffGerejaRules;
    }

    public function messages(): array
    {
        return [
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, dan angka.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
