<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Custom Rules
use Illuminate\Validation\Rule;
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
            'types' => 'nullable|string',
            'rating' => ['required', 'string', new RatingValues],
            'seen' => 'in:true,false,0,1',
            'possession_state' => ['required', 'string', new PossessionStateValues],
            'poster_link' => 'nullable|url',
            'file_remove' => 'nullable|in:true,false,0,1',
            'file' => 'nullable|image|dimensions:min_width=230,min_height=310',
            'actor' => 'nullable|string',
            'duration' => 'nullable|integer',
        ];
    }
}
