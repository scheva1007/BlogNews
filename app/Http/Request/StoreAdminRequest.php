<?php

namespace App\Http\Request;

use App\Models\Schedule;
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
            'round' => 'required|integer|min:1',
            'home_team_id' => [
                'required',
                'exists:teams,id',
                'different:away_team_id',
                function($attribute, $value, $fail) {
                    $exists = Schedule::where('championship_id', $this->championship_id)
                        ->where(function ($query) use ($value) {
                            $query->where('home_team_id', $value)
                                ->orWhere('away_team_id', $value);
                        })
                        ->where(function ($query) {
                            $query->where('round', $this->round)
                            ->orWhereDate('match_date', Carbon::parse($this->match_date)->toDateString());
                        })
                        ->exists();
                    if ($exists) {
                        $fail('Ця команда вже задіяна');
                    }
                }
                ],
            'away_team_id' => [
                'required',
                'exists:teams,id',
                'different:home_team_id',
                function($attribute, $value, $fail) {
                    $exists = Schedule::where('championship_id', $this->championship_id)
                        ->where(function ($query) use ($value) {
                            $query->where('home_team_id', $value)
                                ->orWhere('away_team_id', $value);
                        })
                        ->where(function ($query) {
                            $query->where('round', $this->round)
                                ->orWhereDate('match_date', Carbon::parse($this->match_date)->toDateString());
                        })
                        ->exists();
                    if ($exists) {
                        $fail('Ця команда вже задіяна');
                    }
                }
                ],
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'match_date' => 'required|date',
            'status' => 'required',
        ];
    }
}
