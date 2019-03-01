<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieSearchRequest extends FormRequest
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
            'director' => 'nullable|string',
            'first_letter' => 'nullable|string|alpha|size:1',
            'not_in' => 'nullable|string',
            'number' => 'nullable|numeric',
            'order' => 'nullable|in:ASC,DESC,asc,desc',
            'order_by' => 'nullable|in:created_at,title',
            'possession_state' => 'nullable|in:own,to_own',
            'rating' => 'nullable|in:fantastic,bad',
            'offset' => 'nullable|numeric',
            'seen' => 'nullable|boolean',
            'types' => 'nullable|string',
        ];
    }
}
