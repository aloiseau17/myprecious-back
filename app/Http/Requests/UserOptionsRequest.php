<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserOptionsRequest extends FormRequest
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
            'list_order' => 'nullable|string|in:ASC,DESC,asc,desc',
            'list_order_by' => 'nullable|string|in:created_at,title',
        ];
    }
}
