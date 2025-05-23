<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        $rules = [
            'username' => 'required|string|max:255|unique:users,username,' . $this->route('id'),
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'email' => 'required|email|max:255|unique:users,email,' . $this->route('id'),
            'user_type' => 'required|string|max:50',
            'status' => 'required|in:Active,Deactivate',
            'passcode' => 'nullable|string|max:255',
        ];
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        } else if ($this->isMethod('put')) {
            $rules['password'] = 'nullable|string|min:6|confirmed';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid',
            'password.required' => 'Password is required',
            'password.confirmed' => 'Passwords do not match',
        ];
    }
}
