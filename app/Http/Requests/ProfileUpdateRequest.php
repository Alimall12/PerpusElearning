<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];

        // Add anggota fields if user has anggota
        if ($this->user()->anggota) {
            $rules['nama_lengkap'] = ['required', 'string', 'max:100'];
            $rules['alamat'] = ['required', 'string', 'max:200'];
            $rules['no_telepon'] = [
                'required',
                'string',
                'max:20',
                Rule::unique('anggota', 'no_telepon')->ignore($this->user()->anggota->id),
            ];
        }

        return $rules;
    }
}
