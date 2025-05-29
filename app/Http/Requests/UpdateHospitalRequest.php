<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hospitalId = $this->route('hospital')->id ?? null;
        return [
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:255|unique:hospitals,username,' . $hospitalId,
            'password' => 'nullable|string|min:6',
            'passcode' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }
} 