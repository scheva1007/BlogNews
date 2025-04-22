<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeasonChampionshipRequest extends FormRequest
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
            'championship_id' => 'required|exists:championships,id',
            'season' => 'required|string',
            'teams' => "required|array",
        ];
    }
}
