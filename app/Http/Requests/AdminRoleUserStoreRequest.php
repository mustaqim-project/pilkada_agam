<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoleUserStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:admins,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'role' => ['required'],
            'kode_bank' => ['required', 'exists:bank,kode_bank'],  // Validasi kode_bank
            'no_rek' => ['required', 'max:20']  // Validasi no_rek
            'jum_gaji' => ['required', 'max:50']  // Validasi no_rek
        ];
    }
}
