<?php

namespace App\Http\Request;

use App\Models\Schedule;
use App\Rules\TeamNotBusy;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAdminRequest extends FormRequest
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
            'season' => 'required|string|max:255',
            'round' => 'required|integer|min:1',
            'match_date' => 'required|date',
            'home_team_id' => [
                'required',
                'exists:teams,id',
                'different:away_team_id',
                new TeamNotBusy(
                    $this->championship_id,
                    $this->season,
                    $this->round,
                    $this->match_date
                )
                ],
            'away_team_id' => [
                'required',
                'exists:teams,id',
                'different:home_team_id',
                new TeamNotBusy(
                    $this->championship_id,
                    $this->season,
                    $this->round,
                    $this->match_date
                )
                ],
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required',
        ];
    }
}
