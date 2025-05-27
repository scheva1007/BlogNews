<?php

namespace App\Rules;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class TeamNotBusy implements Rule
{
    protected $championshipId;
    protected $season;
    protected $round;
    protected $matchDate;

    public function __construct($championshipId, $season, $round, $matchDate)
    {
        $this->championshipId = $championshipId;
        $this->season = $season;
        $this->round = $round;
        $this->matchDate = $matchDate;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !Schedule::where('championship_id', $this->championshipId)
            ->where('season', $this->season)
            ->where(function ($query) use ($value) {
                $query->where('home_team_id', $value)
                    ->orWhere('away_team_id', $value);
            })
            ->where(function ($query) {
                $query->where('round', $this->round)
                    ->orWhereDate('match_date', Carbon::parse($this->matchDate)->toDateString());
            })
            ->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Ця команда вже задіяна у цьому турі або на цю дату.';
    }
}
