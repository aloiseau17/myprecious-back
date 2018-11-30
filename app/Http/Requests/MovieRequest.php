<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Custom Rules
use App\Rules\RatingValues;
use App\Rules\PossessionStateValues;

class MovieRequest extends FormRequest
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
            'title' => 'required|string',
            'director' => 'nullable|string',
            'type' => 'nullable|string',
            'rating' => ['required', 'string', new RatingValues],
            'possession_state' => ['required', 'string', new PossessionStateValues],
            'image' => 'nullable|string',
        ];
    }
}
