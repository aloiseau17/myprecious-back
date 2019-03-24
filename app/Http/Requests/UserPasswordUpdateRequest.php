<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Custom Rules
use App\Rules\OldPasswordValues;

class UserPasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => ['required', new OldPasswordValues],
            'password' => 'required|confirmed|different:old_password|min:6',
        ];
    }
}
