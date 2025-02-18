<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Notification;
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
}
