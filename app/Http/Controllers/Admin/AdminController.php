<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Request\StoreAdminRequest;
use App\Models\Championship;
use App\Models\News;
use App\Models\Notification;
use App\Models\Schedule;
use App\Models\Team;
use App\Models\User;
use App\Services\StoreAdminService;
use Illuminate\Http\Request;

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
        $teams = Team::pluck('name', 'id');
        $statuses = ['scheduled' => 'Заплановано', 'finished' => 'Завершено'];

        return view('admin.createMatch', compact('championships', 'teams', 'statuses'));
    }

    public function storeMatch(StoreAdminRequest $request, StoreAdminService $service)
    {
        $service->create($request);

        return redirect()->route('admin.index');
    }

    public function editMatch($matchId)
    {
        $matches = Schedule::findOrFile($matchId);
        $championships = Championship::all();
        $teams = Team::all();

        return view('admin.editMatch', compact('matches', 'championships', 'teams'));

    }

    public function teamsChampionship($championshipId)
    {
        $teams = Team::join('teams_championship', 'teams.id', '=', 'teams_championship.team_id')
            ->where('teams_championship.championship_id', $championshipId)
            ->select('teams.id', 'teams.name')->get();

        return response()->json($teams);
    }
}
