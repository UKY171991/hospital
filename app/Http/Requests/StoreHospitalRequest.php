<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHospitalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|string|max:255|unique:hospitals,username',
            'password' => 'required|string|min:6',
            'passcode' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'contact_no' => 'nullable|string|max:20',
            'pan_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ];
    }
} 