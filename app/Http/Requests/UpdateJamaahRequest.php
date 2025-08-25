<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJamaahRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $jamaah = $this->route('jamaah');
        
        // Staff and superadmin can update any jamaah
        if ($user && ($user->isSuperadmin() || $user->isStaffadmin())) {
            return true;
        }
        
        // Jamaah can only update their own data
        return $user && $user->jamaah && $user->jamaah->id === $jamaah->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $jamaah = $this->route('jamaah');
        
        return [
            'nik' => 'required|string|size:16|unique:jamaah,nik,' . $jamaah->id,
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
}