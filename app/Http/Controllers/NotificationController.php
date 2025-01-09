<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        $notifications = Notification::with('news')
            ->where('user_id', $user->id)
            ->latest()->get();

        return view('news.notification', compact('notifications'));
    }
}
