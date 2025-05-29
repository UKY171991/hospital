<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id ?? null;
        return [
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => 'nullable|string|min:6',
            'passcode' => 'nullable|string|max:255',
            'user_type' => 'required|string|max:255',
            'mobile_no' => 'nullable|string|max:20',
            'status' => 'required|in:Active,Deactivate',
        ];
    }
} 