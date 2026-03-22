<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|regex:/^[\p{L} .]+$/u|max:100',
            'phone' => 'required|regex:/^[6-9][0-9]{9}$/|unique:users',
            'email' => 'nullable|email|max:191|unique:users',
            'password' => 'required|min:8|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required.',
            'name.regex' => 'Name can only contain letters, spaces, and dots.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid 10-digit phone number.',
            'phone.unique' => 'This phone number is already registered.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ];
    }
}