<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'credential' => 'required|string',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'credential.required' => 'Email or phone number is required.',
            'password.required' => 'Password is required.',
        ];
    }
}