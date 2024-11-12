<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Request\UpdateAdminRequest;
use App\Models\News;
use App\Models\User;
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

    public function untested()
    {
        $untestedNews = News::where('checked', false)
            ->where('approved', false)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.untestedNews', compact('untestedNews'));
    }

    public function check($newsId)
    {
        $news = News::findOrFail($newsId);
        $news->checked = true;
        $news->approved = true;
        $news->rejection = null;
        $news->save();

        return redirect()->route('admin.untestedNews');
    }

    public function reject(Request $request, $newsId)
    {
        $news = News::findOrFail($newsId);
        $news->checked = true;
        $news->approved = false;
        $news->rejection = $request->input('rejection');
        $news->save();

        return redirect()->route('admin.untestedNews');
    }

    public function edit ($userId)
    {
        $user = User::findOrFail($userId);
        $roles = ['admin', 'author', 'registered'];

        return view('admin.edit', compact('user', 'roles'));
    }

    public function update (Request $request, User $user)
    {
        $user->update([
            'role' => $request->role,
        ]);

        return redirect()->route('user.index');
    }
}
