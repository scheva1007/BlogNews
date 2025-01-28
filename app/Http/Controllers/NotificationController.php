<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        $notifications = Notification::with('news')
            ->where('user_id', $user->id)
            ->where('status', false)
            ->latest()->get();

        return view('news.notification', compact('notifications'));
    }

    public function changeStatusNotification(Request $request)
    {
        $notificationId = $request->notification_id;

        $notification = Notification::find($notificationId);
            if ($notification && !$notification->status) {
                $notification->update(['status' => true]);
                return response()->json(['success' => true]);
            }

        return response()->json(['success' => false], 404);
    }
}
