<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJamaahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->isSuperadmin() || $this->user()->isStaffadmin());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'nik' => 'required|string|size:16|unique:jamaah,nik',
            'full_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'place_of_birth' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'nationality' => 'required|string|max:100',
            'occupation' => 'nullable|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_phone' => 'required|string|max:20',
            'medical_notes' => 'nullable|string',
            'status' => 'required|in:registered,documents_pending,documents_complete,ready_to_depart,departed,returned',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'User wajib dipilih.',
            'user_id.exists' => 'User tidak ditemukan.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus 16 digit.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'place_of_birth.required' => 'Tempat lahir wajib diisi.',
            'date_of_birth.required' => 'Tanggal lahir wajib diisi.',
            'date_of_birth.before' => 'Tanggal lahir harus sebelum hari ini.',
            'nationality.required' => 'Kewarganegaraan wajib diisi.',
            'emergency_contact_name.required' => 'Nama kontak darurat wajib diisi.',
            'emergency_contact_phone.required' => 'Nomor kontak darurat wajib diisi.',
            'status.required' => 'Status wajib dipilih.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if (!$this->has('status')) {
            $this->merge(['status' => 'registered']);
        }
        
        if (!$this->has('nationality')) {
            $this->merge(['nationality' => 'Indonesia']);
        }
    }
}