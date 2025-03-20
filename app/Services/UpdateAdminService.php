<?php

namespace App\Services;

use App\Http\Request\UpdateAdminRequest;
use App\Models\Schedule;

class UpdateAdminService
{
    public function update(UpdateAdminRequest $request, Schedule $match)
    {
        $match->update([
            'home_score' => $request->home_score,
            'away_score' => $request->away_score,
            'match_date' => $request->match_date,
            'status' => $request->status,
        ]);
    }
}
