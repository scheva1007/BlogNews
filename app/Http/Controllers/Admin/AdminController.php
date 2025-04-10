<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Request\StoreAdminRequest;
use App\Http\Request\UpdateAdminRequest;
use App\Models\Championship;
use App\Models\News;
use App\Models\Notification;
use App\Models\Schedule;
use App\Models\Team;
use App\Models\User;
use App\Services\StoreAdminService;
use App\Services\UpdateAdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index (User $user)
    {
        return view ('admin.index', compact('user'));
    }

    public function allPublications ()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(8);

        return view('admin.allPublications', compact('news'));
    }

    public function unchecked()
    {
        $uncheckedNews = News::where('checked', false)
            ->where('approved', false)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.uncheckedNews', compact('uncheckedNews'));
    }

    public function approve(News $news)
    {
        $news->checked = true;
        $news->approved = true;
        $news->rejection_reason = null;
        $news->save();

        $author = $news->author;
        $subscribers = $author->subscribers->pluck('subscriber_id');
        foreach ($subscribers as $subscriber) {
            Notification::create([
                'user_id' => $subscriber,
                'news_id' => $news->id,
                'message_type' => 'subscription',
            ]);
        }

        return redirect()->route('admin.uncheckedNews');
    }

    public function reject(Request $request, News $news)
    {
        $news->checked = true;
        $news->approved = false;
        $news->rejection_reason = $request->input('rejection_reason');
        $news->save();

        return redirect()->route('admin.uncheckedNews');
    }

    public function createMatch()
    {
        $championships = Championship::pluck('name', 'id');
        $statuses = ['scheduled' => 'Заплановано', 'finished' => 'Завершено'];

        return view('admin.championships.createMatch', compact('championships','statuses'));
    }

    public function storeMatch(StoreAdminRequest $request, StoreAdminService $service)
    {
        $service->create($request);

        return redirect()->route('admin.index');
    }

    public function editMatch($matchId)
    {
        $matches = Schedule::with(['homeTeam', 'awayTeam'])->findOrFail($matchId);
        $teams = Team::all();
        $statuses = ['scheduled' => 'Заплановано', 'finished' => 'Завершено'];

        return view('admin.championships.editMatch', compact('matches', 'teams', 'statuses'));

    }

    public function updateMatch(UpdateAdminRequest $request, UpdateAdminService $service, $matchId)
    {
        $match = Schedule::findOrFail($matchId);
        $service->update($request, $match);

        return redirect()->route('admin.index');
    }

    public function getSeason($championshipId)
    {
        $season = DB::table('championships')
            ->where('id', $championshipId)
            ->distinct()->pluck('season');

        return response()->json($season);
    }

    public function getTeams($championshipId, $season)
    {
        $teams = DB::table('teams')
            ->join('teams_championship', 'teams.id', '=', 'teams_championship.team_id')
            ->join('championships', 'teams_championship.championship_id', '=', 'championships.id')
            ->where('championships.id', $championshipId)
            ->where('championships.season', $season)
            ->select('teams.id', 'teams.name')->get();

        return response()->json($teams);
    }

    public function teamsChampionship($championshipId)
    {
        $teams = Team::join('teams_championship', 'teams.id', '=', 'teams_championship.team_id')
            ->where('teams_championship.championship_id', $championshipId)
            ->select('teams.id', 'teams.name')
            ->distinct()->get();

        if ($teams->isEmpty()) {
            $teams = Team::select('id', 'name')->get();
        }

        return response()->json($teams);
    }

    public function allChampionship()
    {
        $championship = Championship::paginate(10);

        return view('admin.championships.allChampionship', compact('championship'));
    }

    public function championshipRounds($championshipId)
    {
        $rounds = Schedule::where('championship_id', $championshipId)
            ->select('round')->distinct()
            ->orderBy('round')->get();

        return view('admin.championships.championshipRounds', compact('rounds', 'championshipId'));
    }

    public function roundMatches($championshipId, $round)
    {
        $matches = Schedule::where('championship_id', $championshipId)
            ->where('round', $round)
            ->with(['homeTeam', 'awayTeam'])->get();

        return view('admin.championships.roundMatches', compact('matches', 'championshipId', 'round'));
    }
}
