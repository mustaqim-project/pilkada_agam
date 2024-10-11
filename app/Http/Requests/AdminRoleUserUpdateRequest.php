<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRoleUserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('role_user');

        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email', 'unique:admins,email,'.$id],
            'role' => ['required'],
            'kode_bank' => ['required', 'exists:banks,kode_bank'],  // Validasi kode_bank
            'no_rek' => ['required', 'max:20'],  // Validasi no_rek
            'jum_gaji' => ['required']  // Validasi no_rek
        ];
    }
}
