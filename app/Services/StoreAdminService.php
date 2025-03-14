<?php

namespace App\Services;


use App\Http\Request\StoreAdminRequest;
use App\Models\Schedule;

class StoreAdminService
{
    public function create(StoreAdminRequest $request)
    {
        return Schedule::create([
            'championship_id' => $request->championship_id,
            'round' => $request->round,
            'home_team_id' => $request->home_team_id,
            'away_team_id' => $request->away_team_id,
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'match_date' => $request->match_date,
            'status' => $request->status,
        ]);
    }
}
