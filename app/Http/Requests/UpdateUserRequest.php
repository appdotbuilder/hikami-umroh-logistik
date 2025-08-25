<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $targetUser = $this->route('user');
        
        // Superadmin can edit anyone
        if ($user && $user->isSuperadmin()) {
            return true;
        }
        
        // Users can edit themselves
        return $user && $user->id === $targetUser->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $targetUser = $this->route('user');
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $targetUser->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ];

        // Only superadmin can change role and status
        if ($this->user() && $this->user()->isSuperadmin()) {
            $rules['role'] = 'required|in:superadmin,staffadmin,jamaah';
            $rules['is_active'] = 'boolean';
        }

        // Password is optional for updates
        if ($this->filled('password')) {
            $rules['password'] = ['confirmed', Password::min(8)];
        }

        return $rules;
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'role.required' => 'Role pengguna wajib dipilih.',
            'role.in' => 'Role pengguna tidak valid.',
        ];
    }
}